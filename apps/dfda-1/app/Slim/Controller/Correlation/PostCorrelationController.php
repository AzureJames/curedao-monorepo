<?php /*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */ /** @noinspection PhpUnused */
namespace App\Slim\Controller\Correlation;
use App\Correlations\QMUserCorrelation;
use App\Exceptions\QMException;
use App\Slim\Controller\PostController;
use App\Types\QMArr;
/** Class PostCorrelationController
 * @package App\Slim\Controller\Correlation
 */
class PostCorrelationController extends PostController {
	public function post(){
		QMUserCorrelation::makeCorrelation($this->getCauseVariableId(true), $this->getEffectVariableId(true),
			$this->getCorrelationCoefficient());
		return $this->writeJsonWithGlobalFields(201, ['status' => 'ok']);
	}
	/**
	 * @return float
	 */
	public function getCorrelationCoefficient(){
		$requestBody = $this->getRequestJsonBodyAsArray(false);
		$requestBody = QMArr::replaceLegacyKeys($requestBody, QMUserCorrelation::getLegacyRequestParameters());
		if(empty($requestBody['correlationCoefficient'])){
			throw new QMException(400, 'correlationCoefficient is not specified');
		}
		return (float)$requestBody['correlationCoefficient'];
	}
}
