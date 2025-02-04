<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Properties\Correlation;
use App\Exceptions\NotEnoughDataException;
use App\Models\Correlation;
use App\Traits\PropertyTraits\CorrelationProperty;
use App\Properties\Base\BaseCauseNumberOfProcessedDailyMeasurementsProperty;
use App\Traits\PropertyTraits\IsCalculated;
use App\Correlations\QMUserCorrelation;
class CorrelationCauseNumberOfProcessedDailyMeasurementsProperty extends BaseCauseNumberOfProcessedDailyMeasurementsProperty
{
    use CorrelationProperty;
    use IsCalculated;
    public $table = Correlation::TABLE;
    public $parentClass = Correlation::class;
    /**
     * @param QMUserCorrelation $model
     * @return int
     * @throws \App\Exceptions\NotEnoughDataException
     */
    public static function calculate($model): int {
        $cMeasurements = $model->getMeasurementsFromCauseVariable();
        $value = count($cMeasurements);
        if($value < self::MINIMUM_PROCESSED_DAILY_MEASUREMENTS_WITH_TAGS_JOINS_CHILDREN){
            throw new NotEnoughDataException($model,
                "At least 3 cause measurements are required but there are only $value daily measurements for "
                .$model->getCauseVariableName());
        }
        $model->setAttribute(static::NAME, $value);
        return $value;
    }
    public function showOnUpdate(): bool {return false;}
    public function showOnCreate(): bool {return false;}
    public function showOnIndex(): bool {return false;}
    public function showOnDetail(): bool {return true;}
}
