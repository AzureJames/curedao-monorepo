<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Buttons\RelationshipButtons\Unit;
use App\Buttons\RelationshipButtons\HasManyRelationshipButton;
use App\Models\Correlation;
use App\Models\Unit;
class UnitCorrelationsWhereCauseUnitButton extends HasManyRelationshipButton {
	public $interesting = true;
	public $parentClass = Unit::class;
	public $qualifiedParentKeyName = Unit::TABLE . '.' . Unit::FIELD_ID;
	public $relatedClass = Correlation::class;
	public $methodName = 'correlations_where_cause_unit';
	public $relationshipType = 'Illuminate\\Database\\Eloquent\\Relations\\HasMany';
	public $color = Correlation::COLOR;
	public $fontAwesome = Correlation::FONT_AWESOME;
	public $id = 'correlations-where-cause-unit-button';
	public $image = Correlation::DEFAULT_IMAGE;
	public $text = 'Correlations Where Cause Unit';
	public $title = 'Correlations Where Cause Unit';
	public $tooltip = 'Correlations where this is the Cause Unit';
}
