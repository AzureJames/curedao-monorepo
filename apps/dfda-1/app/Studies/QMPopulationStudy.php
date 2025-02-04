<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Studies;
use App\Buttons\StudyButton;
use App\Correlations\QMAggregateCorrelation;
use App\Correlations\QMCorrelation;
use App\Correlations\QMUserCorrelation;
use App\Exceptions\NotEnoughDataException;
use App\Models\AggregateCorrelation;
use App\Models\Study;
use App\Properties\Study\StudyIdProperty;
use App\Properties\Study\StudyTypeProperty;
use App\Storage\S3\S3Public;
use App\Traits\HasCorrelationCoefficient;
use App\Traits\HasModel\HasAggregateCorrelation;
use App\UI\IonIcon;
use Illuminate\View\View;
use App\Slim\Model\User\QMUser;
/** Class PopulationStudy
 * @package app/Studies
 */
class QMPopulationStudy extends QMStudy {
    use HasAggregateCorrelation;
	const TYPE = StudyTypeProperty::TYPE_POPULATION;
    public const COLLECTION_NAME = "PopulationStudy";
    public const CLASS_PARENT_CATEGORY = Study::CLASS_CATEGORY;
    public static function getS3Bucket():string{return S3Public::getBucketName();}
    public const UNIQUE_INDEX_COLUMNS = [
        self::FIELD_CAUSE_VARIABLE_ID,
        self::FIELD_EFFECT_VARIABLE_ID,
        self::FIELD_TYPE,
        //self::FIELD_USER_ID // Must be unique or we have duplicate study id's
    ];
	/**
	 * @param Study|null $study
	 */
    public function __construct(Study $study = null){
		if(!$study){return;}
        $this->setType(StudyTypeProperty::TYPE_POPULATION);
	    $study->type = StudyTypeProperty::TYPE_POPULATION;
        parent::__construct($study);
    }
    /**
     * @param null $causeNameOrId
     * @param null $effectNameOrId
     * @param int|null $userId
     * @param string|null $type
     * @return QMCohortStudy|QMPopulationStudy
     */
    public static function findOrCreateQMStudy($causeNameOrId = null,
                                            $effectNameOrId = null,
                                            int $userId = null,
                                            string $type = null): QMStudy {
        $study = parent::findOrCreateQMStudy($causeNameOrId, $effectNameOrId, $userId, StudyTypeProperty::TYPE_POPULATION);
        return $study;
    }
	/**
	 * @param null $causeNameOrId
	 * @param null $effectNameOrId
	 * @param int|null $userId
	 * @param string|null $type
	 * @return QMCohortStudy|QMPopulationStudy
	 */
	public static function findOrNewQMStudy($causeNameOrId = null,
		$effectNameOrId = null,
		int $userId = null,
		string $type = null): QMStudy {
		$study = parent::findOrNewQMStudy($causeNameOrId, $effectNameOrId, $userId, StudyTypeProperty::TYPE_POPULATION);
		return $study;
	}
	/**
	 * @param null $causeNameOrId
	 * @param null $effectNameOrId
	 * @param int|null $userId
	 * @param string|null $type
	 * @return QMCohortStudy|QMPopulationStudy
	 */
	public static function findInMemoryOrNewQMStudy($causeNameOrId = null,
		$effectNameOrId = null,
		int $userId = null,
		string $type = null): QMStudy {
		$study = parent::findInMemoryOrNewQMStudy($causeNameOrId, $effectNameOrId, $userId, StudyTypeProperty::TYPE_POPULATION);
		return $study;
	}
    /**
     * @return int
     */
    public function getUserId(): ?int {
        return $this->userId ?: QMStudy::DEFAULT_PRINCIPAL_INVESTIGATOR_ID;
    }
    /**
     * @param string|int $causeNameOrId
     * @param string|int $effectNameOrId
     * @param int|null $userId
     * @param string|null $type
     * @return string
     */
    public static function generateStudyId($causeNameOrId, $effectNameOrId, int $userId = null, string $type = null): string{
        $clientId = StudyIdProperty::generateStudyIdPrefix($causeNameOrId, $effectNameOrId).
            StudyIdProperty::POPULATION_STUDY_ID_SUFFIX;
        return $clientId;
    }
    /**
     * @param array $arr
     * @param string|null $reason
     * @return int
     * @deprecated Use Eloquent model save directly
     */
    public function updateDbRow(array $arr, string $reason = null): int {
        unset($arr[self::FIELD_USER_ID]); // Need to unset user_id this because it tries to overwrite with same user_id which violates index for some reason
        return parent::updateDbRow($arr, $reason);
    }
    /**
     * @return QMAggregateCorrelation
     */
    public function setHasCorrelationCoefficientFromDatabase(): ?QMAggregateCorrelation{
        return $this->correlationFromDatabase =
            QMAggregateCorrelation::getByIds($this->getCauseVariableId(), $this->getEffectVariableId());
    }
    /**
     * @return QMAggregateCorrelation|QMUserCorrelation
     * @throws NotEnoughDataException
     */
    public function getCreateOrRecalculateStatistics(): QMCorrelation{
        if($c = $this->getHasCorrelationCoefficientIfSet()){
            return $c;
        }
        $c = $this->getOrCreateAggregateCorrelation();
        return $this->setStatistics($c);
    }
    /**
     * @return string
     */
    public function getCategoryDescription(): string{
        return AggregateCorrelation::CLASS_DESCRIPTION;
    }
    /**
     * @return QMCorrelation
     * @throws NotEnoughDataException
     */
    public function createStatistics(): QMCorrelation{
        return $this->createAggregateCorrelation();
    }
	/**
	 * @return AggregateCorrelation|HasCorrelationCoefficient
	 * @throws \App\Exceptions\DuplicateFailedAnalysisException
	 * @throws \App\Exceptions\ModelValidationException
	 * @throws \App\Exceptions\NotEnoughDataException
	 * @throws \App\Exceptions\StupidVariableNameException
	 * @throws \App\Exceptions\TooSlowToAnalyzeException
	 */
    public function getHasCorrelationCoefficient(){
        $c = $this->findAggregateCorrelation();
		if(!$c){
			$c = $this->createAggregateCorrelation();
		}
		return $c;
    }
    /**
     * @return string
     */
    public function getTitleWithUserName(): string {
        return $this->getTitleAttribute()." for Population";
    }
    public function getQMUser(): QMUser{
        return QMUser::population();
    }
    public function getIonIcon(): string {
        return IonIcon::androidGlobe;
    }
    public static function getIndexPageView(): View{
        return view('studies-index', [
            'buttons' => static::generateIndexButtons(),
            'heading' => "Population Studies"
        ]);
    }
    public static function generateIndexButtons(): array{
        $correlations = AggregateCorrelation::getUpVoted();
        return StudyButton::toButtons($correlations);
    }
    public function getShowContentView(array $params = []): View{
        try {
            $this->getHasCorrelationCoefficient();
        } catch (NotEnoughDataException $e) {
            $this->logError($e->getMessage());
        }
        return view('population-study-content', $this->getShowParams($params));
    }
    public function getShowPageView(array $params = []): View{
        try {
            $this->getHasCorrelationCoefficient();
        } catch (NotEnoughDataException $e) {
            $this->logError($e->getMessage());
        }
        return view('population-study', $this->getShowParams($params));
    }
    public function getUrlSubPath(): string{
        return $this->getId();
    }
    public function getStudyType(): string{
        return StudyTypeProperty::TYPE_POPULATION;
    }
	/**
	 * @param int|null $precision
	 * @return float|null
	 */
	public function getCorrelationCoefficient(int $precision = null): ?float{
		$c = $this->findAggregateCorrelation();
		if(!$c){return null;}
		return $c->getCorrelationCoefficient($precision);
	}
	/**
	 * @return \App\Models\AggregateCorrelation
	 */
	public function findAggregateCorrelation():?AggregateCorrelation{
		if($this->statistics === false){
			return null;
		}
		if($this->statistics instanceof AggregateCorrelation){
            return $this->statistics;
        }
		if($this->statistics instanceof QMAggregateCorrelation){
			return $this->statistics->l();
		}
		if($this->statistics instanceof NotEnoughDataException){
			return null;
		}
		$c = AggregateCorrelation::findByVariableNamesOrIds($this->getCauseVariableId(),
			$this->getEffectVariableId());
		if(!$c){
			$this->statistics = false;
			return null;
		}
		return $this->statistics = $c;
	}
}
