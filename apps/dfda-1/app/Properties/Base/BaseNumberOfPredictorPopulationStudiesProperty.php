<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Properties\Base;
use App\Traits\PropertyTraits\IsString;
use App\Models\AggregateCorrelation;
use App\Traits\PropertyTraits\IsNumberOfRelated;
use App\UI\ImageUrls;
use App\UI\FontAwesome;
use App\Properties\BaseProperty;
use Illuminate\Support\Str;
class BaseNumberOfPredictorPopulationStudiesProperty extends BaseProperty{
	use IsNumberOfRelated;
	public $dbInput = 'integer,false,true';
	public $dbType = \Doctrine\DBAL\Types\Types::INTEGER;
	public $default = \OpenApi\Generator::UNDEFINED;
	public $description = 'Number of Global Population Studies';
	public $fieldType = self::TYPE_INTEGER;
	public $fontAwesome = FontAwesome::CREATE_STUDY;
	public $htmlType = self::TYPE_NUMBER;
	public $image = ImageUrls::SEND_PREDICTOR_EMAILS;
	public $isOrderable = true;
	public $isSearchable = false;
	public $name = self::NAME;
	public const NAME = 'number_of_predictor_population_studies';
	public $phpType = \App\Types\PhpTypes::INTEGER;
	public $title = 'Predictor Population Studies';
	public $type = self::TYPE_INTEGER;
    public static function getRelatedTable(): string{
        return AggregateCorrelation::TABLE;
    }
    public static function getForeignKey(): string{
        return "effect_".Str::snake(static::getParentShortClassName())."_id";
    }
}
