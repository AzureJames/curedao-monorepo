<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Properties\Correlation;
use App\Exceptions\InvalidAttributeException;
use App\Exceptions\NotEnoughMeasurementsForCorrelationException;
use App\Models\Correlation;
use App\Traits\PropertyTraits\CorrelationProperty;
use App\Properties\Base\BaseExperimentStartAtProperty;
use App\Correlations\QMUserCorrelation;
use App\Traits\PropertyTraits\IsCalculated;
class CorrelationExperimentStartAtProperty extends BaseExperimentStartAtProperty
{
    use CorrelationProperty;
    public $table = Correlation::TABLE;
    public $parentClass = Correlation::class;
    use IsCalculated;
    /**
     * @param QMUserCorrelation $model
     * @return string
     * @throws NotEnoughMeasurementsForCorrelationException
     */
    public static function calculate($model): string{
        $cause = $model->getCauseUserVariable();
        $effect = $model->getEffectUserVariable();
        $cEarliestFillingAt = $cause->getEarliestFillingAt();
        if(!$cEarliestFillingAt){
            throw new NotEnoughMeasurementsForCorrelationException("No $cause->name measurements found. ", $model);
        }
        $eEarliestFillingAt = $effect->getEarliestFillingAt();
        if(!$eEarliestFillingAt){
            throw new NotEnoughMeasurementsForCorrelationException("No $effect->name measurements found. ", $model);
        }
        $experimentStartAt = max([$cEarliestFillingAt, $eEarliestFillingAt]);
        $model->setAttribute(static::NAME, $experimentStartAt);
        try {
            $model->validateAttribute(static::NAME);
        } catch (InvalidAttributeException $e) {
            le($e);
        }
        return $experimentStartAt;
    }
}
