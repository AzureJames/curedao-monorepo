<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Astral\Lenses;
use App\Models\AggregateCorrelation;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\LensRequest;
class AggregateCorrelationsWithNullChangeLens extends AggregateCorrelationInvalidLens {
	public function name(): string{
		return "Change is Null";
	}
	/**
	 * Get the query builder / paginator for the lens.
	 * @param LensRequest $request
	 * @param Builder $query
	 * @return mixed
	 */
	public static function query(LensRequest $request, $query){
		$query->whereNull(AggregateCorrelation::FIELD_EFFECT_FOLLOW_UP_PERCENT_CHANGE_FROM_BASELINE)
			->orderBy(AggregateCorrelation::FIELD_ANALYSIS_STARTED_AT, BaseModel::ORDER_DIRECTION_DESC);
		$withFilters = $request->withFilters($query);
		return $request->withOrdering($withFilters);
	}
}
