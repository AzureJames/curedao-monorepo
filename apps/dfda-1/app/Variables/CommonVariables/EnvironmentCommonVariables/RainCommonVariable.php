<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Variables\CommonVariables\EnvironmentCommonVariables;
use App\UI\ImageUrls;
use App\Variables\QMCommonVariable;
use App\VariableCategories\EnvironmentVariableCategory;
use App\Units\CountUnit;
class RainCommonVariable extends QMCommonVariable {
	public const CAUSE_ONLY = false;
	public const COMBINATION_OPERATION = 'SUM';
	public const DEFAULT_UNIT_ID = CountUnit::ID;
	public const CREATOR_USER_ID = 0;
	public const DURATION_OF_ACTION = 604800;
	public const FILLING_VALUE = 0.0;
	public const ID = 97848;
	public const IMAGE_URL = ImageUrls::AGRICULTURE_RAIN;
	public const MANUAL_TRACKING = false;
	public const NAME = 'Rain';
	public const ONSET_DELAY = 0;
	public const OUTCOME = false;
	public const PRICE = 1.29;
	public const PRODUCT_URL = 'https://www.amazon.com/Rain-Remastered/dp/B0198BDC7Y?linkCode=xm2&camp=2025&creative=165953&creativeASIN=B0198BDC7Y';
	public const PUBLIC = true;
	public const SYNONYMS = ['Rain'];
	public const VARIABLE_CATEGORY_ID = EnvironmentVariableCategory::ID;
	public $causeOnly = self::CAUSE_ONLY;

	public $defaultUnitId = self::DEFAULT_UNIT_ID;
	public $creatorUserId = self::CREATOR_USER_ID;
	public $durationOfAction = self::DURATION_OF_ACTION;
	public ?float $fillingValue = self::FILLING_VALUE;
	public $id = self::ID;
	public $imageUrl = self::IMAGE_URL;
	public $manualTracking = self::MANUAL_TRACKING;
	public $name = self::NAME;
	public $onsetDelay = self::ONSET_DELAY;
	public $outcome = self::OUTCOME;
	public float $price = self::PRICE;
	public $productUrl = self::PRODUCT_URL;
	public $public = self::PUBLIC;
	public $synonyms = self::SYNONYMS;
	public $variableCategoryId = self::VARIABLE_CATEGORY_ID;
}
