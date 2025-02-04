<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Properties\Correlation;
use App\Models\Correlation;
use App\Traits\PropertyTraits\CorrelationProperty;
use App\Properties\Base\BaseForwardSpearmanCorrelationCoefficientProperty;
use App\Traits\PropertyTraits\IsCalculated;
use App\Utils\Stats;
use App\Correlations\QMUserCorrelation;
class CorrelationForwardSpearmanCorrelationCoefficientProperty extends BaseForwardSpearmanCorrelationCoefficientProperty
{
    use CorrelationProperty;
    use IsCalculated;
    public $table = Correlation::TABLE;
    public $parentClass = Correlation::class;
    /**
     * @param QMUserCorrelation $model
     * @return float|int|null
     * @throws \App\Exceptions\NotEnoughDataException
     * @throws \App\Exceptions\TooSlowToAnalyzeException
     */
    public static function calculate($model){
        $causeValues = $model->getCauseValues();
        $effectValues = $model->getEffectValues();
        $cc = Stats::testSpearman($causeValues, $effectValues);
        $model->setAttribute(static::NAME, $cc);
        return $cc;
    }
}
