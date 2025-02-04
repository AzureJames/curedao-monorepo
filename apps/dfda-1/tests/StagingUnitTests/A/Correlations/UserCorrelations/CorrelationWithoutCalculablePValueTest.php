<?php /** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpUnusedLocalVariableInspection */
namespace Tests\StagingUnitTests\A\Correlations\UserCorrelations;
use App\Exceptions\NotEnoughDataException;
use Tests\SlimStagingTestCase;
use App\Correlations\QMUserCorrelation;
class CorrelationWithoutCalculablePValueTest extends SlimStagingTestCase
{
    public function testCorrelationWithoutCalculablePValue(): void{
		$c = QMUserCorrelation::getOrCreateUserCorrelation(230, 5977655, 1251);
        // This changes from new data. Just compare HTML in Unit Tests. $this->compareHtmlFixture('correlation-html', $c->getHtml());
		try {
            $c->analyzeFullyAndSave('we are testing');
            $this->assertTrue(false, "Should have thrown NotEnoughDataException");
		} catch (NotEnoughDataException $e){
		    $this->assertTrue(true);
		}
		$this->checkTestDuration(15);
		$this->checkQueryCount(20);
	}
}
