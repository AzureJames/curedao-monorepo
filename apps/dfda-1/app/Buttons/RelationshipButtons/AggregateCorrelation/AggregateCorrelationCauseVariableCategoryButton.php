<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Buttons\RelationshipButtons\AggregateCorrelation;
use App\Buttons\RelationshipButtons\BelongsToRelationshipButton;
use App\Models\VariableCategory;
use App\Models\AggregateCorrelation;
class AggregateCorrelationCauseVariableCategoryButton extends BelongsToRelationshipButton {
    public $interesting = true;
	public $foreignKeyName = AggregateCorrelation::FIELD_CAUSE_VARIABLE_CATEGORY_ID;
	public $qualifiedForeignKeyName = AggregateCorrelation::TABLE.'.'.AggregateCorrelation::FIELD_CAUSE_VARIABLE_CATEGORY_ID;
	public $ownerKeyName = VariableCategory::FIELD_ID;
	public $qualifiedOwnerKeyName = VariableCategory::TABLE.'.'.VariableCategory::FIELD_ID;
	public $childClass = AggregateCorrelation::class;
	public $parentClass = AggregateCorrelation::class;
	public $qualifiedParentKeyName = AggregateCorrelation::TABLE.'.'.AggregateCorrelation::FIELD_ID;
	public $relatedClass = VariableCategory::class;
	public $methodName = 'cause_variable_category';
	public $relationshipType = 'Illuminate\\Database\\Eloquent\\Relations\\BelongsTo';
	public $color = VariableCategory::COLOR;
	public $fontAwesome = VariableCategory::FONT_AWESOME;
	public $id = 'cause-variable-category-button';
	public $image = VariableCategory::DEFAULT_IMAGE;
	public $text = 'Cause Variable Category';
	public $title = 'Cause Variable Category';
	public $tooltip = VariableCategory::CLASS_DESCRIPTION;

}
