<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Traits\PropertyTraits;
use App\Models\Correlation;
use App\Traits\HasModel\HasCorrelation;
trait CorrelationProperty {
	use HasCorrelation;
	public function getCorrelationId(): int{
		return $this->getParentModel()->getId();
	}
	public function getCorrelation(): Correlation{
		return $this->getParentModel();
	}
}
