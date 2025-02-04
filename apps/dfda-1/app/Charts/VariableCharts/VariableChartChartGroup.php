<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Charts\VariableCharts;
use App\Charts\AggregateCorrelationCharts\AggregateCorrelationsNetworkGraphQMChart;
use App\Charts\AggregateCorrelationCharts\AggregateCorrelationsSankeyQMChart;
use App\Charts\ChartGroup;
use App\Charts\DistributionColumnChart;
use App\Charts\MonthlyColumnChart;
use App\Charts\QMChart;
use App\Charts\WeekdayColumnChart;
use App\Charts\YearlyColumnChart;
use App\Models\Correlation;
use App\Variables\QMVariable;
class VariableChartChartGroup extends ChartGroup {
	public $distributionColumnChart;
	public $weekdayColumnChart;
	public $monthlyColumnChart;
	public $yearlyColumnChart;
	/**
	 * @var AggregateCorrelationsSankeyQMChart
	 */
	public $aggregateCorrelationsSankeyChart;
	public $aggregateCorrelationsNetworkGraphChart;
	/**
	 * CommonVariableCharts constructor.
	 * @param QMVariable|null $variable
	 */
	public function __construct($variable = null){
		if(!$variable){
			return;
		} // Probably instantiating Mongo document
		$this->sourceObject = $variable;
		$this->distributionColumnChart = new DistributionColumnChart($variable);
		$this->weekdayColumnChart = new WeekdayColumnChart($variable);
		$this->monthlyColumnChart = new MonthlyColumnChart($variable);
		$this->yearlyColumnChart = new YearlyColumnChart($variable);
		$this->aggregateCorrelationsSankeyChart =
			new AggregateCorrelationsSankeyQMChart($variable, null, Correlation::MAX_LIMIT);
		$this->aggregateCorrelationsNetworkGraphChart =
			new AggregateCorrelationsNetworkGraphQMChart($variable, null, Correlation::MAX_LIMIT);
		parent::__construct($variable);
	}
	public function unsetPrivateAndProtectedProperties(){
		foreach($this as $key => $value){
			/** @var QMChart $value */
			if($value){
				$value->unsetPrivateAndProtectedProperties();
			}
		}
	}
	/**
	 * @return bool|QMChart[]
	 */
	public function getChartsArray(): array{
		$charts = [];
		$charts[] = $this->getDistributionColumnChart();
		$charts[] = $this->getWeekdayColumnChart();
		$charts[] = $this->getMonthlyColumnChart();
		$charts[] = $this->getYearlyColumnChart();
		$charts[] = $this->getAggregateCorrelationsSankeyChart();
		$charts[] = $this->getAggregateCorrelationsNetworkGraphChart();
		return $charts;
	}
	/**
	 * @return DistributionColumnChart
	 */
	public function getDistributionColumnChart(): DistributionColumnChart{
		if($this->distributionColumnChart){
			$c = DistributionColumnChart::instantiateIfNecessary($this->distributionColumnChart);
		} else{
			$c = new DistributionColumnChart($this->getSourceObject());
		}
		return $this->distributionColumnChart = $c;
	}
	/**
	 * @return WeekdayColumnChart
	 */
	public function getWeekdayColumnChart(): WeekdayColumnChart{
		if($this->weekdayColumnChart){
			$c = WeekdayColumnChart::instantiateIfNecessary($this->weekdayColumnChart);
		} else{
			$c = new WeekdayColumnChart($this->getSourceObject());
		}
		return $this->weekdayColumnChart = $c;
	}
	/**
	 * @return AggregateCorrelationsSankeyQMChart
	 */
	public function getAggregateCorrelationsSankeyChart(): AggregateCorrelationsSankeyQMChart{
		if($this->aggregateCorrelationsSankeyChart){
			$c = AggregateCorrelationsSankeyQMChart::instantiateIfNecessary($this->aggregateCorrelationsSankeyChart);
		} else{
			$c = new AggregateCorrelationsSankeyQMChart($this->getSourceObject());
		}
		return $this->aggregateCorrelationsSankeyChart = $c;
	}
	/**
	 * @return AggregateCorrelationsNetworkGraphQMChart
	 */
	public function getAggregateCorrelationsNetworkGraphChart(): AggregateCorrelationsNetworkGraphQMChart{
		if($this->aggregateCorrelationsNetworkGraphChart){
			$c =
				AggregateCorrelationsNetworkGraphQMChart::instantiateIfNecessary($this->aggregateCorrelationsNetworkGraphChart);
		} else{
			$c = new AggregateCorrelationsNetworkGraphQMChart($this->getSourceObject());
		}
		return $this->aggregateCorrelationsNetworkGraphChart = $c;
	}
	/**
	 * @return MonthlyColumnChart
	 */
	public function getMonthlyColumnChart(): MonthlyColumnChart{
		if($this->monthlyColumnChart){
			$c = MonthlyColumnChart::instantiateIfNecessary($this->monthlyColumnChart);
		} else{
			$c = new MonthlyColumnChart($this->getSourceObject());
		}
		return $this->monthlyColumnChart = $c;
	}
	/**
	 * @return YearlyColumnChart
	 */
	public function getYearlyColumnChart(): YearlyColumnChart{
		if($this->yearlyColumnChart){
			$c = YearlyColumnChart::instantiateIfNecessary($this->yearlyColumnChart);
		} else{
			$c = new YearlyColumnChart($this->getSourceObject());
		}
		return $this->yearlyColumnChart = $c;
	}
	public function getHtmlWithDynamicCharts(bool $includeJS): string{
		return parent::getHtmlWithDynamicCharts($includeJS);
	}
	public static function generateDescriptiveCharts($v): string{
		return DistributionColumnChart::generateInline($v) . WeekdayColumnChart::generateInline($v) .
			MonthlyColumnChart::generateInline($v) . YearlyColumnChart::generateInline($v);
	}
}
