<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Buttons\DataLab\Correlations;
use App\Buttons\QMButton;
use App\Models\Correlation;
class ListCorrelationsButton extends QMButton {
	public $accessibilityText = 'List Correlations';
	public $action = 'datalab/correlations';
	public $color = Correlation::COLOR;
	public $fontAwesome = Correlation::FONT_AWESOME;
	public $id = 'datalab-correlations-button';
	public $image = Correlation::DEFAULT_IMAGE;
	public $link = 'datalab/correlations';
	public $parameters = [
		'middleware' => [
			'web',
			'auth',
		],
		'as' => 'datalab.correlations.index',
		'uses' => 'App\\Http\\Controllers\\DataLab\\CorrelationController@index',
		'controller' => 'App\\Http\\Controllers\\DataLab\\CorrelationController@index',
		'namespace' => 'App\\Http\\Controllers',
		'prefix' => '/datalab',
		'where' => [],
	];
	public $target = 'self';
	public $text = 'List Correlations';
	public $title = 'List Correlations';
	public $tooltip = Correlation::CLASS_DESCRIPTION;
	public $visible = true;
}
