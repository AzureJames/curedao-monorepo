<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Properties\Application;
use App\Models\Application;
use App\Traits\PropertyTraits\ApplicationProperty;
use App\Properties\Base\BasePredictorVariableIdProperty;
class ApplicationPredictorVariableIdProperty extends BasePredictorVariableIdProperty
{
    use ApplicationProperty;
    public $table = Application::TABLE;
    public $parentClass = Application::class;
}
