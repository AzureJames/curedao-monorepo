<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Properties\VariableCategory;
use App\Models\VariableCategory;
use \App\Traits\PropertyTraits\VariableCategoryProperty;
use App\Properties\Base\BaseAmazonProductCategoryProperty;
class VariableCategoryAmazonProductCategoryProperty extends BaseAmazonProductCategoryProperty
{
    use VariableCategoryProperty;
    public $table = VariableCategory::TABLE;
    public $parentClass = VariableCategory::class;
}
