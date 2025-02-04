<?php /*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */ /** @noinspection PhpUnhandledExceptionInspection */
namespace App\PhpUnitJobs\Cleanup;
use App\Correlations\QMAggregateCorrelation;
use App\Correlations\QMUserCorrelation;
use App\Models\AggregateCorrelation;
use App\Models\Correlation;
use App\PhpUnitJobs\JobTestCase;
use App\Properties\Correlation\CorrelationInternalErrorMessageProperty;
use App\Variables\QMCommonVariable;
use App\Variables\QMUserVariable;
use App\Variables\QMVariable;
class CorrelationsCleanUpJob extends JobTestCase {
    public function testCleanup(){
        CorrelationInternalErrorMessageProperty::fixInvalidRecords();
        //CorrelationCauseNumberOfRawMeasurementsProperty::fixTooSmall();
    }
    public static function testDeleteStupidCorrelations(){
        $variables = QMVariable::getStupidVariables();
        foreach($variables as $v){
            $deleted = false;
            $deleted = $deleted || QMUserCorrelation::writable()
                    ->where(Correlation::FIELD_CAUSE_VARIABLE_ID, $v->getVariableIdAttribute())
                    ->hardDelete(__METHOD__, true);
            $deleted = $deleted || QMUserCorrelation::writable()
                    ->where(Correlation::FIELD_EFFECT_VARIABLE_ID, $v->getVariableIdAttribute())
                    ->hardDelete(__METHOD__, true);
            $deleted = $deleted || QMAggregateCorrelation::writable()
                    ->where(AggregateCorrelation::FIELD_CAUSE_VARIABLE_ID, $v->getVariableIdAttribute())
                    ->hardDelete(__METHOD__, true);
            $deleted = $deleted || QMAggregateCorrelation::writable()
                    ->where(AggregateCorrelation::FIELD_EFFECT_VARIABLE_ID, $v->getVariableIdAttribute())
                    ->hardDelete(__METHOD__, true);
            if($deleted){
                QMUserVariable::setStatusWaitingByVariableId($v->getVariableIdAttribute(), __FUNCTION__);
                QMCommonVariable::setStatusWaitingByVariableId($v->getVariableIdAttribute(), __FUNCTION__);
            }
        }
    }
}
