<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Exceptions;
use App\Correlations\QMUserCorrelation;
use App\Properties\Correlation\CorrelationCauseChangesProperty;
class InsufficientVarianceException extends NotEnoughDataException {
    /**
     * @var QMUserCorrelation
     */
    public $userCorrelation;
    /**
     * InsufficientVarianceException constructor.
     * @param QMUserCorrelation $correlation
     * @param string $problemDetails
     * @param string|null $internalErrorMessage
     */
    public function __construct(QMUserCorrelation $correlation, string $problemDetails = '',
                                string $internalErrorMessage = null){
        $this->analyzable = $this->userCorrelation = $correlation;
        $causeEffect = $correlation->getCauseAndEffectString();
        $problemDetails .= "There is not enough variance in the data to create a study on the relationship between $causeEffect. ".
            $correlation->getChangesVarianceSentence().
            " At least ". CorrelationCauseChangesProperty::MINIMUM_CHANGES ." changes in values are necessary because we're trying to see what happens to ".
            $correlation->getEffectNameWithoutCategoryOrUnit()." when ".
            $correlation->getCauseNameWithoutCategoryOrUnit()." is ".
                "above average and what happens when it's below average. "
        ;
        parent::__construct($correlation, "Not Enough Variance In Data",
            $problemDetails, $internalErrorMessage);
    }
    public function getDocumentationLinks(): array{
        return $this->links = [
            "View Data" => $this->getAnalyzable()->getUrl()
        ];
    }
}
