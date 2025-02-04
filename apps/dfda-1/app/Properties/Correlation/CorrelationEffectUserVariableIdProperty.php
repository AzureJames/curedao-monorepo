<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Properties\Correlation;
use App\Models\Correlation;
use App\Traits\PropertyTraits\CorrelationProperty;
use App\Properties\Base\BaseEffectUserVariableIdProperty;
use App\Http\Requests\AstralRequest;
class CorrelationEffectUserVariableIdProperty extends BaseEffectUserVariableIdProperty
{
    use CorrelationProperty;
    public $table = Correlation::TABLE;
    public $parentClass = Correlation::class;
    public function showOnUpdate(): bool {return false;}
    public function showOnCreate(): bool {return false;}
    public function showOnDetail(): bool {return true;}
    public function showOnIndex(): bool {
        return AstralRequest::forRelationshipTable("correlations_where_cause_user_variable");
    }
}
