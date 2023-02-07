<?php

namespace Jp\Jpfaq\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * The repository for Questions
 */
class QuestionRepository extends Repository
{
    /**
     * @var array
     */
    protected $defaultOrderings = array(
        'sorting' => QueryInterface::ORDER_ASCENDING
    );

    /**
     * Find questions with constraints
     *
     * @param array $categories
     * @param bool $excludeAlreadyDisplayedQuestions
     *
     * @throws InvalidQueryException
     * @return array|QueryResultInterface
     */
    public function findQuestionsWithConstraints(array $categories = [], bool $excludeAlreadyDisplayedQuestions = false)
    {
        $query = $this->createQuery();
        $constraintsOr = [];
        $constraintsAnd = [];

        if (!empty($categories)) {
            # categories can be multi-valued, show questions which belong to one of the choosen categories
            foreach ($categories as $demandedCategory) {
                $constraintsOr[] = $query->contains('categories', $demandedCategory);
            }
        }

        if ($excludeAlreadyDisplayedQuestions && isset($GLOBALS['EXT']['jpfaq']['alreadyDisplayed']) && !empty($GLOBALS['EXT']['jpfaq']['alreadyDisplayed'])) {
            $constraintsAnd[] = $query->logicalNot(
                $query->in(
                    'uid',
                    $GLOBALS['EXT']['jpfaq']['alreadyDisplayed']
                )
            );
        }

        if (!empty($constraintsOr) && !empty($constraintsAnd)) {
            $query->matching($query->logicalAnd([
                $query->logicalOr($constraintsOr),
                $query->logicalOr($constraintsAnd)
            ]));
        } elseif (!empty($constraintsOr)) {
            $query->matching($query->logicalOr($constraintsOr));
        } elseif (!empty($constraintsAnd)) {
            $query->matching($query->logicalAnd($constraintsAnd));
        }

        return $query->execute();
    }
}
