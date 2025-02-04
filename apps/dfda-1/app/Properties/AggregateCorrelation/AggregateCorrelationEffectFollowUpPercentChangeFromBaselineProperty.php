<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Properties\AggregateCorrelation;
use App\Exceptions\NotEnoughDataException;
use App\Exceptions\TooSlowToAnalyzeException;
use App\Logging\QMLog;
use App\Models\AggregateCorrelation;
use App\Traits\PropertyTraits\AggregateCorrelationProperty;
use App\Properties\Base\BaseEffectFollowUpPercentChangeFromBaselineProperty;
use App\Traits\HasCauseAndEffect;
use App\Traits\PropertyTraits\IsAverageOfCorrelations;
use App\Traits\PropertyTraits\IsCalculated;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use App\Fields\Field;
use LogicException;
use App\Variables\QMVariableCategory;
class AggregateCorrelationEffectFollowUpPercentChangeFromBaselineProperty extends BaseEffectFollowUpPercentChangeFromBaselineProperty
{
    use IsCalculated;
    use AggregateCorrelationProperty, IsAverageOfCorrelations;
    public $table = AggregateCorrelation::TABLE;
    public $parentClass = AggregateCorrelation::class;
    public static function query(array $with = []): Builder{
        return parent::query(['cause_variable', 'effect_variable']);
    }
    public static function logNulls(string $title = null) {
        if(!$title){$title = "Have Null ".static::NAME;}
        $before = static::whereNull()->get();
        return HasCauseAndEffect::logCauseAndEffectNames($before, $title);
    }
    public static function analyzeWhereNull(): Collection{
        $qb = static::whereNull();
        $qb->orderBy(AggregateCorrelation::FIELD_ANALYSIS_STARTED_AT, 'asc');
        $aggCorrs = $qb->get();
        QMLog::count($aggCorrs, " where null");
        /** @var AggregateCorrelation $ac */
        foreach($aggCorrs as $ac){
            if($ac->hasBoringCategory() && !$ac->correlations()->count()){
                $ac->forceDelete();
                continue;
            }
            try {
                try {
                    $ac->recalculateUserCorrelations();
                    $ac->analyze(__FUNCTION__);
                } catch (NotEnoughDataException $e) {
                    QMLog::error($e->getMessage()."\nDelete me at: ".$ac->getDataLabDeleteUrl());
                    $noCorrelations[] = $ac;
                } catch (TooSlowToAnalyzeException $e) {
                    le($e);
                }
            } catch (\Throwable $e){
                $errored[$ac->getTitleAttribute()] = $ac;
                QMLog::error(__METHOD__.": ".$e->getMessage());
            }
        }
        return $aggCorrs;
    }
    public static function deleteWhereNullAndStupidCategoryPair($cause, $effect){
        $cause = QMVariableCategory::find($cause);
        $effect = QMVariableCategory::find($effect);
        $qb = static::whereNull();
        $qb->where(AggregateCorrelation::FIELD_CAUSE_VARIABLE_CATEGORY_ID, $cause->id);
        $qb->where(AggregateCorrelation::FIELD_EFFECT_VARIABLE_CATEGORY_ID, $effect->id);
        $qb->withTrashed();
        $rows = $qb->get();
        $names = HasCauseAndEffect::logCauseAndEffectNames($rows, __FUNCTION__);
        QMLog::count($rows,"$cause->name vs $effect->name");
        $qb->forceDelete();
    }
    public static function whereInvalid(): Builder{
        return static::whereNull();
    }
    public function showOnIndex(): bool {return true;}
    public function showOnDetail(): bool {return true;}
}
