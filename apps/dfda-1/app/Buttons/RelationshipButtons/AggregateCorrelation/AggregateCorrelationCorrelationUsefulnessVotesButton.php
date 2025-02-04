<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Buttons\RelationshipButtons\AggregateCorrelation;
use App\Buttons\RelationshipButtons\HasManyRelationshipButton;
use App\Models\CorrelationUsefulnessVote;
use App\Models\AggregateCorrelation;
class AggregateCorrelationCorrelationUsefulnessVotesButton extends HasManyRelationshipButton {
    public $interesting = true;
	public $parentClass = AggregateCorrelation::class;
	public $qualifiedParentKeyName = AggregateCorrelation::TABLE.'.'.AggregateCorrelation::FIELD_ID;
	public $relatedClass = CorrelationUsefulnessVote::class;
	public $methodName = CorrelationUsefulnessVote::TABLE;
	public $relationshipType = 'Illuminate\\Database\\Eloquent\\Relations\\HasMany';
	public $color = CorrelationUsefulnessVote::COLOR;
	public $fontAwesome = CorrelationUsefulnessVote::FONT_AWESOME;
	public $id = 'correlation-usefulness-votes-button';
	public $image = CorrelationUsefulnessVote::DEFAULT_IMAGE;
	public $text = 'Correlation Usefulness Votes';
	public $title = 'Correlation Usefulness Votes';
	public $tooltip = CorrelationUsefulnessVote::CLASS_DESCRIPTION;

}
