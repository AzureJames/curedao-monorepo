<?php /** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpDocMissingThrowsInspection */
namespace Tests\StagingUnitTests\Analyzable;
use App\Correlations\QMUserCorrelation;
use App\Models\Correlation;
use App\Models\Variable;
use App\Variables\QMCommonVariable;
use App\Variables\QMUserVariable;
use App\PhpUnitJobs\Analytics\CommonVariableJob;
use Tests\SlimStagingTestCase;
class AnalyzableTest extends SlimStagingTestCase {
    public const JOB_NAME = "Production-Analyzable-phpunit";
	/**
	 * @covers \App\Charts\QMChart::getUniqueIndexIdsSlug
	 */
	public function testSlugs(){
        $c = QMUserCorrelation::findByNamesOrIds(17901, 5954747, 1398);
        $getUniqueIndexIdsSlug = $c->getUniqueIndexIdsSlug();
        $this->assertEquals("correlations-user-17901-cause-variable-5954747-effect-variable-1398",
            $getUniqueIndexIdsSlug);
        $charts = $c->getOrSetCharts();
        $chart = $charts->getCorrelationsOverDurationsChart();
        $slug = $chart->getUniqueIndexIdsSlug();
        $this->assertEquals("correlations-user-17901-cause-variable-5954747-effect-variable-1398-correlations-over-durations-of-action-chart",
            $slug);
    }
//    public function testAnalyzeVariableForDemoUserWithMissingMeasurements(){
    // What was this for?
//        $v = QMUserVariable::findByNameOrId(1, "Wearing Makeup");
//        $v->analyzeFullyAndSave("testing");
//        $this->assertTrue(true);
//    }
    public function testUserCorrelationAnalysisUsesCommonMinMaxNotUser(): void{
        $c = QMUserCorrelation::getOrCreateUserCorrelation(230, 1508, 1282);
        $c->analyzeFully(__FUNCTION__);
        $this->checkTestDuration(15);
        $this->checkQueryCount(37);
    }
	/**
	 * @covers \App\Models\Correlation::getTagLine
	 */
	public function testCorrelationWithHighPercentChange(){
        $c = Correlation::find(119078140);
        $line = $c->getTagLine();
        $this->assertEquals('Unknown Activities was generally 96 milliseconds higher following above average Overall Mood over the previous 24 hours. ',
            $line);
    }
	/**
	 * @covers \App\Variables\QMUserVariable::analysisJobsTest
	 */
	public function testUserVariableAnalysisJobTest(): void{
        QMUserVariable::analysisJobsTest();
        $this->assertTrue(true);
    }
	/**
	 * @covers \App\Variables\QMCommonVariable::analysisJobsTest
	 */
    public function testCommonVariableAnalysisJobStaging(): void{
		$this->skipTest("Fails randomly");
        QMCommonVariable::analysisJobsTest();
        if(CommonVariableJob::TAG_COUNT_IMPLEMENTED){ // TODO: Figure out a way to update tag count without destroying MySQL
            $whereTagsNull = Variable::query()
                ->whereNull(Variable::FIELD_NUMBER_OF_COMMON_TAGS)
                ->count();
            $this->assertEquals(0, $whereTagsNull,
                "Should have been updated by analyzeGloballyIfNecessary");
        }
        $this->assertTrue(true);
    }

	/**
	 * @covers \App\Variables\QMUserCorrelation::analysisJobsTest
	 */
    public function testUserCorrelationAnalysisJob(): void{
        if($this->skipIfQueued(static::JOB_NAME)){return;}
        // Too slow: UserCleanUpJobTest::deleteOldTestUsers();
        QMUserCorrelation::analysisJobsTest();
        $this->assertTrue(true);
    }
}
