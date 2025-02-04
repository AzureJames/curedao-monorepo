<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Properties\Correlation;
use App\Models\Correlation;
use App\Traits\PropertyTraits\CorrelationProperty;
use App\Properties\Base\BaseQmScoreProperty;
use App\Correlations\QMUserCorrelation;
class CorrelationQmScoreProperty extends BaseQmScoreProperty
{
    use CorrelationProperty;
    public const USE_SIMPLIFIED_QM_SCORE = true;
    public $table = Correlation::TABLE;
    public $parentClass = Correlation::class;
    use \App\Traits\PropertyTraits\IsCalculated;
    /**
     * @param QMUserCorrelation $model
     * @return float|null
     * @noinspection PhpMissingReturnTypeInspection
     */
    public static function calculate($model) {
        $val = CorrelationQmScoreProperty::calculateQmScore($model, null);
        $model->setAttribute(static::NAME, $val);
        return $val;
    }
    /**
     * @param QMUserCorrelation $uc
     * @param $reversePearsonCorrelationSpread
     * @return float
     */
    public static function calculateQmScore(QMUserCorrelation $uc, $reversePearsonCorrelationSpread): float{
        $coefficient = $uc->getCorrelationCoefficient();
        $significance = $uc->getStatisticalSignificance();
        if(self::USE_SIMPLIFIED_QM_SCORE || !$reversePearsonCorrelationSpread){
            $qmScore = abs($coefficient) * $significance;
        }else{
            $noiseLevel = $reversePearsonCorrelationSpread / 2;
	        $predictivePearsonCorrelationCoefficient = $uc->getPredictivePearsonCorrelationCoefficient();
	        $qmScore = (abs($predictivePearsonCorrelationCoefficient) - $noiseLevel) * $significance;
        }
        if($ac = $uc->findAggregateCorrelation()){
            if($aggScore = $ac->aggregate_qm_score){$qmScore += $aggScore;}
        }
        $interestingFactor = $uc->getInterestingFactor();
        $qmScore *= $interestingFactor;
        $qmScore = round($qmScore, 4);
        return $uc->qmScore = $qmScore;
    }
}
