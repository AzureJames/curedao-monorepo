<?php /*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */ /** @noinspection PhpMissingFieldTypeInspection */
namespace App\PhpUnitJobs\Miscellaneous;
use App\Slim\Model\APIStats;
use App\Storage\DB\Writable;
use App\Types\TimeHelper;
use App\Variables\QMCommonVariable;
use App\Models\Connection;
use App\Logging\QMLog;
use App\Correlations\QMUserCorrelation;
use App\Variables\QMUserVariable;
use App\PhpUnitJobs\JobTestCase;
class GeneralUpdateStatusJob extends JobTestCase {
	public $numberOfUserCorrelationsUpdatedInLastHour;
	public $numberOfUserVariablesUpdatedInLastDay;
	public $numberOfCommonVariablesUpdatedInLastHour;
	public $numberOfConnectionsUpdatedInLastHour;
	public function testApiStats(){
		Writable::enableSlowQueryLog();
		try {
			Writable::outputSlowQueries();
		} catch (\Throwable $e) {
			QMLog::info(__METHOD__.": ".$e->getMessage());
		}
		$apiStats = new APIStats();
		foreach($apiStats as $key => $value){
			if(!is_array($value)){
				QMLog::info($key . " = " . $value);
				continue;
			}
			foreach($value as $subKey => $subValue){
				if(!is_array($subValue)){
					QMLog::info($key . " " . $subKey . " = " . $subValue);
					continue;
				}
				foreach($subValue as $subSubKey => $subSubValue){
					if(!is_array($subSubValue)){
						QMLog::info($key . " " . $subKey . " " . $subSubKey . " = " . $subSubValue);
						continue;
					}
					foreach($subSubValue as $subSubSubKey => $subSubSubValue){
						if(!is_array($subSubSubValue) && !is_object($subSubSubValue)){
							QMLog::info($key . " " . $subKey . " " . $subSubKey . " " . $subSubSubKey . " = " .
								$subSubSubValue);
						}
					}
				}
			}
		}
		//$this->assertGreaterThan(0, $apiStats->variables['created']['numberUpdatedInLastDay'], "No common variables created in last day");
		$this->assertGreaterThan(0, $apiStats->variables['updated']['numberUpdatedInLastDay'],
			"No common variables updated in last day");
	}
	public function testNumberOfUserCorrelationsAnalyzedInLastDay(){
		$this->numberOfUserCorrelationsUpdatedInLastHour = QMUserCorrelation::numberAnalyzedSince(time() - 86400);
		QMLog::info("$this->numberOfUserCorrelationsUpdatedInLastHour user correlations updated in last day");
		if(!$this->numberOfUserCorrelationsUpdatedInLastHour){
			QMLog::error("No correlation updates in last day!");
		}
		$this->assertGreaterThan(0, $this->numberOfUserCorrelationsUpdatedInLastHour, __FUNCTION__);
	}
	public function testNumberOfUserVariablesAnalyzedInLastDay(){
		$this->numberOfUserVariablesUpdatedInLastDay = QMUserVariable::numberAnalyzedSince(time() - 86400);
		QMLog::info("$this->numberOfUserVariablesUpdatedInLastDay user user variables updated in last hour");
		if(!$this->numberOfUserVariablesUpdatedInLastDay){
			QMLog::error("No user variable updates in last hour!");
		}
		$this->assertGreaterThan(0, $this->numberOfUserVariablesUpdatedInLastDay, __FUNCTION__);
	}
	public function testNumberOfCommonVariablesAnalyzedInLastHour(){
		$this->numberOfCommonVariablesUpdatedInLastHour = QMCommonVariable::numberAnalyzedSince(time() - 86400);
		QMLog::info("$this->numberOfCommonVariablesUpdatedInLastHour user common variables updated in last hour");
		if(!$this->numberOfCommonVariablesUpdatedInLastHour){
			QMLog::info("No CommonVariablesUpdated updates in last hour!");
		}
		$this->assertGreaterThan(0, $this->numberOfCommonVariablesUpdatedInLastHour, __FUNCTION__);
	}
	public function testNumberOfConnectorImportsInLastTwoHours(){
		$seconds = 2 * 3600;
		$numberImported = Connection::numberImportedSince(time() - $seconds);
		$m = "$numberImported imported in last " . TimeHelper::convertSecondsToHumanString($seconds);
		QMLog::info($m);
		$this->assertGreaterThan(0, $numberImported, $m);
	}
}
