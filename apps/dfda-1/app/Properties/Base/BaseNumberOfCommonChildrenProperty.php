<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Properties\Base;
use App\Traits\PropertyTraits\IsInt;
use App\UI\ImageUrls;
use App\UI\FontAwesome;
use App\Properties\BaseProperty;
class BaseNumberOfCommonChildrenProperty extends BaseProperty{
	use IsInt;
	public $dbInput = 'integer,false';
	public $dbType = \Doctrine\DBAL\Types\Types::INTEGER;
	public $default = \OpenApi\Generator::UNDEFINED;
	public $description = 'number_of_common_children';
	public $fieldType = self::TYPE_INTEGER;
	public $fontAwesome = FontAwesome::COMMON_TAG;
	public $htmlType = self::TYPE_NUMBER;
	public $image = ImageUrls::COMMON_TAG;
	public $importance = false;
	public $isOrderable = false;
	public $isSearchable = false;
	public $name = self::NAME;
	public const NAME = 'number_of_common_children';
	public $canBeChangedToNull = true;
	public $phpType = \App\Types\PhpTypes::INTEGER;
	public $showOnDetail = true;
	public $title = 'Common Children';
	public $type = self::TYPE_INTEGER;

}
