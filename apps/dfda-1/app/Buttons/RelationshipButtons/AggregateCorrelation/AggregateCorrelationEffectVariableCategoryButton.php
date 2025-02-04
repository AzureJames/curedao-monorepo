<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Buttons\RelationshipButtons\AggregateCorrelation;
use App\Buttons\RelationshipButtons\BelongsToRelationshipButton;
use App\Models\VariableCategory;
use App\Models\AggregateCorrelation;
class AggregateCorrelationEffectVariableCategoryButton extends BelongsToRelationshipButton {
	public $foreignKeyName = AggregateCorrelation::FIELD_EFFECT_VARIABLE_CATEGORY_ID;
	public $qualifiedForeignKeyName = AggregateCorrelation::TABLE.'.'.AggregateCorrelation::FIELD_EFFECT_VARIABLE_CATEGORY_ID;
	public $ownerKeyName = VariableCategory::FIELD_ID;
	public $qualifiedOwnerKeyName = VariableCategory::TABLE.'.'.VariableCategory::FIELD_ID;
	public $childClass = AggregateCorrelation::class;
	public $parentClass = AggregateCorrelation::class;
	public $qualifiedParentKeyName = AggregateCorrelation::TABLE.'.'.AggregateCorrelation::FIELD_ID;
	public $relatedClass = VariableCategory::class;
	public $methodName = 'effect_variable_category';
	public $relationshipType = 'Illuminate\\Database\\Eloquent\\Relations\\BelongsTo';
	public $color = VariableCategory::COLOR;
	public $fontAwesome = VariableCategory::FONT_AWESOME;
	public $id = 'effect-variable-category-button';
	public $image = VariableCategory::DEFAULT_IMAGE;
	public $text = 'Effect Variable Category';
	public $title = 'Effect Variable Category';
	public $tooltip = VariableCategory::CLASS_DESCRIPTION;

}
