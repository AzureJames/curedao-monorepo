<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Properties\Correlation;
use App\Charts\QMHighcharts\MultivariateHighstock;
use App\Exceptions\NotEnoughDataException;
use App\Exceptions\NotEnoughMeasurementsForCorrelationException;
use App\Logging\QMLog;
use App\Models\Correlation;
use App\Traits\PropertyTraits\CorrelationProperty;
use App\Properties\Base\BaseNumberOfPairsProperty;
use App\Traits\PropertyTraits\IsCalculated;
use App\Types\TimeHelper;
use App\Correlations\QMUserCorrelation;
class CorrelationNumberOfPairsProperty extends BaseNumberOfPairsProperty
{
    use CorrelationProperty;
    use IsCalculated;
    public $table = Correlation::TABLE;
    public $parentClass = Correlation::class;
    /**
     * @param QMUserCorrelation $model
     * @return int
     * @throws \App\Exceptions\NotEnoughDataException
     * @throws \App\Exceptions\TooSlowToAnalyzeException
     */
    public static function calculate($model): int{
        $pairs = $model->getPairs();
        $count = count($pairs);
        $model->setAttribute(static::NAME, $count);
        if($count < self::MINIMUM_PAIRS){
            throw new NotEnoughDataException($model, "Only $count pairs");
        }
        return $count;
    }
    /**
     * @param $count
     * @param null $model
     * @throws NotEnoughMeasurementsForCorrelationException
     * @noinspection PhpParameterNameChangedDuringInheritanceInspection
     */
    public static function validateByValue($count, $model = null){
        $cause = $model->getOrSetCauseQMVariable();
        $effect = $model->getOrSetEffectQMVariable();
        if($count < BaseNumberOfPairsProperty::MINIMUM_PAIRS){
            $delay = $model->getOnsetDelay();
            $duration = $model->getDurationOfAction();
            $basedOnCause = $model->setPairsBasedOnDailyCauseValues();
            $basedOnEffect = $model->setPairsBasedOnDailyEffectValues();
            $causeMeasurements = $cause->getDailyMeasurementsWithTagsAndFilling();
            $effectMeasurements = $effect->getDailyMeasurementsWithTagsAndFilling();
            $chart = new MultivariateHighstock([$model->getCauseQMVariable()->id, $model->getEffectQMVariable()->id]);
            $url = $chart->getUrl();
            \App\Logging\ConsoleLog::info($url);
            $causeEffect = $model->getCauseAndEffectString();
            throw new NotEnoughMeasurementsForCorrelationException(
                "There are only $model->numberOfPairs but we require at least "
                .
                BaseNumberOfPairsProperty::MINIMUM_PAIRS." days of overlapping data between $causeEffect with onset delay ".
                TimeHelper::convertSecondsToHumanString($delay).
                " and ".TimeHelper::convertSecondsToHumanString($duration)." duration of action. See chart at $url",
                $model,
                $model->getOrSetCauseQMVariable(),
                $model->getOrSetEffectQMVariable());
        }
    }
    public function validateMin(): void{
        parent::validateMin();
    }
}
