<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Properties\Correlation;
use App\Models\Correlation;
use App\Traits\PropertyTraits\CorrelationProperty;
use App\Properties\Base\BaseEffectBaselineStandardDeviationProperty;
use App\Utils\Stats;
use App\Correlations\QMUserCorrelation;
class CorrelationEffectBaselineStandardDeviationProperty extends BaseEffectBaselineStandardDeviationProperty
{
    use CorrelationProperty;
    use \App\Traits\PropertyTraits\IsCalculated;
    public $table = Correlation::TABLE;
    public $parentClass = Correlation::class;
    /**
     * @param QMUserCorrelation $model
     * @return float|null
     * @throws \App\Exceptions\NotEnoughDataException
     * @throws \App\Exceptions\TooSlowToAnalyzeException
     * @noinspection PhpMissingReturnTypeInspection
     */
    public static function calculate($model) {
        $val = Stats::standardDeviation($model->getBaselineEffectValues());
        if (!$val) { // This happens when all baseline values are the same so we'll just use all effect values
            $effect = $model->getOrSetEffectQMVariable();
            $val = $effect->getStandardDeviation();
        }
        $model->setAttribute(static::NAME, $val);
        return $val;
    }
}
