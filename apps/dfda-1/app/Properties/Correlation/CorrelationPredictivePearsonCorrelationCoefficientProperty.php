<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Properties\Correlation;
use App\Models\Correlation;
use App\Traits\PropertyTraits\CorrelationProperty;
use App\Properties\Base\BasePredictivePearsonCorrelationCoefficientProperty;
use App\Correlations\QMUserCorrelation;
use App\Traits\PropertyTraits\IsCalculated;
class CorrelationPredictivePearsonCorrelationCoefficientProperty extends BasePredictivePearsonCorrelationCoefficientProperty
{
    use CorrelationProperty;
	use IsCalculated;
    public $table = Correlation::TABLE;
    public $parentClass = Correlation::class;
    /**
     * @param QMUserCorrelation $model
     * @return float|null
     * @throws \App\Exceptions\NotEnoughDataException
     * @throws \App\Exceptions\TooSlowToAnalyzeException
     */
    public static function calculate($model): ?float{
		$reverse = $model->reversePearsonCorrelationCoefficient;
		if($reverse === null){
			$reverse = CorrelationReversePearsonCorrelationCoefficientProperty::calculate($model);
		}
	    $forwardPearsonCorrelationCoefficient = $model->getForwardPearsonCorrelationCoefficient();
	    $val = $forwardPearsonCorrelationCoefficient - $reverse;
        $model->setAttribute(self::NAME, $val);
        return $val;
    }
}
