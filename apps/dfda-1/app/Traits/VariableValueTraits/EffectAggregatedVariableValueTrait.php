<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Traits\VariableValueTraits;
use App\Models\AggregateCorrelation;
use App\Models\Correlation;
use App\Models\Variable;
use App\Variables\QMVariable;
trait EffectAggregatedVariableValueTrait {
	use AggregatedVariableValueTrait;
	public function getVariable(): Variable{
		/** @var AggregateCorrelation|Correlation $correlation */
		$correlation = $this->getParentModel();
		return $correlation->getEffectVariable();
	}
	public function getDuration(): int{
		/** @var Correlation $c */
		$c = $this->getParentModel();
		return $c->duration_of_action;
	}
	public function getQMVariable(): QMVariable{ return $this->getVariable()->getDBModel(); }
}
