<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Properties\Correlation;
use App\Models\Correlation;
use App\Traits\PropertyTraits\CorrelationProperty;
use App\Properties\Base\BaseCauseUserVariableIdProperty;
use App\Http\Requests\AstralRequest;
class CorrelationCauseUserVariableIdProperty extends BaseCauseUserVariableIdProperty
{
    use CorrelationProperty;
    public $table = Correlation::TABLE;
    public $parentClass = Correlation::class;
    public function showOnUpdate(): bool {return false;}
    public function showOnCreate(): bool {return false;}
    public function showOnIndex(): bool {
        return AstralRequest::forRelationshipTable("correlations_where_effect_user_variable");
    }
    public function showOnDetail(): bool {return true;}

}
