<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Buttons\RelationshipButtons\VariableCategory;
use App\Buttons\RelationshipButtons\HasManyRelationshipButton;
use App\Models\Correlation;
use App\Models\VariableCategory;
class VariableCategoryCorrelationsWhereCauseVariableCategoryButton extends HasManyRelationshipButton {
	public $interesting = true;
	public $parentClass = VariableCategory::class;
	public $qualifiedParentKeyName = VariableCategory::TABLE . '.' . VariableCategory::FIELD_ID;
	public $relatedClass = Correlation::class;
	public $methodName = 'correlations_where_cause_variable_category';
	public $relationshipType = 'Illuminate\\Database\\Eloquent\\Relations\\HasMany';
	public $color = Correlation::COLOR;
	public $fontAwesome = Correlation::FONT_AWESOME;
	public $id = 'correlations-where-cause-variable-category-button';
	public $image = Correlation::DEFAULT_IMAGE;
	public $text = 'Correlations Where Cause Variable Category';
	public $title = 'Correlations Where Cause Variable Category';
	public $tooltip = 'Correlations where this is the Cause Variable Category';
}
