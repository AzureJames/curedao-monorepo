<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Buttons\RelationshipButtons\User;
use App\Buttons\RelationshipButtons\HasManyRelationshipButton;
use App\Models\TrackingReminderNotification;
use App\Models\User;
class UserTrackingReminderNotificationsButton extends HasManyRelationshipButton {
	public $interesting = true;
	public $parentClass = User::class;
	public $qualifiedParentKeyName = 'id';
	public $relatedClass = TrackingReminderNotification::class;
	public $methodName = TrackingReminderNotification::TABLE;
	public $relationshipType = 'Illuminate\\Database\\Eloquent\\Relations\\HasMany';
	public $color = TrackingReminderNotification::COLOR;
	public $fontAwesome = TrackingReminderNotification::FONT_AWESOME;
	public $id = 'tracking-reminder-notifications-button';
	public $image = TrackingReminderNotification::DEFAULT_IMAGE;
	public $text = TrackingReminderNotification::CLASS_DISPLAY_NAME;
	public $title = TrackingReminderNotification::CLASS_DISPLAY_NAME;
	public $tooltip = TrackingReminderNotification::CLASS_DESCRIPTION;
}
