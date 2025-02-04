<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Astral\Filters;
class NumericMultiColumnFilter extends TextFilter {
	//public $component = 'multicolumn-numeric-filter';
	protected $default_column_type = 'number';
	protected function operatorsDefault(): array{
		return [
			'=' => '=',
			'>' => '>',
			'>=' => '>=',
			'<' => '<',
			'<=' => '<=',
			//'LIKE' => 'Like',
		];
	}
}
