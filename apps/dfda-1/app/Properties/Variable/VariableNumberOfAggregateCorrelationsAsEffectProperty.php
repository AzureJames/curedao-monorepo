<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn 
 */

namespace App\Properties\Variable;
use App\Models\AggregateCorrelation;
use App\Models\Variable;
use App\Traits\PropertyTraits\IsNumberOfRelated;
use App\Traits\PropertyTraits\VariableProperty;
use App\Properties\Base\BaseNumberOfAggregateCorrelationsAsEffectProperty;
use App\Correlations\QMAggregateCorrelation;
use App\Variables\QMCommonVariable;
class VariableNumberOfAggregateCorrelationsAsEffectProperty extends BaseNumberOfAggregateCorrelationsAsEffectProperty
{
    use VariableProperty;
    use IsNumberOfRelated;
    public $table = Variable::TABLE;
    public $parentClass = Variable::class;
    /**
     * @param QMCommonVariable $model
     * @return int
     */
    public static function calculate($model): int{
        $val = QMAggregateCorrelation::readonly()
            ->where(AggregateCorrelation::FIELD_EFFECT_VARIABLE_ID, $model->getVariableIdAttribute())
            ->whereNull(AggregateCorrelation::FIELD_DELETED_AT)
            ->count();
        $model->setAttribute(static::NAME, $val);
        return $val;
    }
    public function validate(): void {
        parent::validate();
        $v = $this->getVariable();
        $val = $this->getDBValue();
        if($v->best_cause_variable_id && !$val){
            $this->throwException("best_cause_variable_id but there are not correlations");
        }
    }
    public function showOnUpdate(): bool {return false;}
    public function showOnCreate(): bool {return false;}
    public function showOnIndex(): bool {return false;}
    public function showOnDetail(): bool {
        if(!$this->parentIsPopulated()){return true;}
        return $this->getDBValue() || $this->getVariable()->isOutcome() !== false;
    }
    protected static function getRelatedTable():string{return AggregateCorrelation::TABLE;}
    public static function getForeignKey():string{return AggregateCorrelation::FIELD_EFFECT_VARIABLE_ID;}
    protected static function getLocalKey():string{return Variable::FIELD_ID;}
    protected static function getRelationshipClass(): string{return AggregateCorrelation::class;}
}
