<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Properties\Correlation;
use App\Models\Correlation;
use App\Properties\Base\BaseCombinationOperationProperty;
use App\Traits\PropertyTraits\CorrelationProperty;
use App\Properties\Base\BaseCauseTreatmentAveragePerDayProperty;
use App\Correlations\QMUserCorrelation;
use App\Slim\Model\Measurement\Pair;
class CorrelationCauseTreatmentAveragePerDayProperty extends BaseCauseTreatmentAveragePerDayProperty
{
    use CorrelationProperty;
    use \App\Traits\PropertyTraits\IsCalculated;
    public $table = Correlation::TABLE;
    public $parentClass = Correlation::class;
    /**
     * @param QMUserCorrelation $model
     * @return int
     * @throws \App\Exceptions\NotEnoughDataException
     * @throws \App\Exceptions\TooSlowToAnalyzeException
     */
    public static function calculate($model): float {
        $pairs = $model->getFollowupPairs();
        $value = Pair::getAverageCauseValue($pairs);
        if($model->getCauseVariable()->isSum()){
            $value = $value / $model->getDurationOfActionInDays();
        }
        $model->setAttribute(static::NAME, $value);
        return $value;
    }
}
