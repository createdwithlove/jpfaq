<?php

namespace Jp\Jpfaq\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
/**
 * Question
 */
class Question extends AbstractEntity
{
    /**
     * question
     *
     * @Validate("NotEmpty")
     *
     * @var string
     */
    protected $question = '';

    /**
     * answer
     *
     * @Validate("NotEmpty")
     *
     * @var string
     */
    protected $answer = '';

    /**
     * helpful
     *
     * @Validate("NotEmpty")
     *
     * @var int
     */
    protected $helpful = '';

    /**
     * nothelpful
     *
     * @Validate("NotEmpty")
     *
     * @var int
     */
    protected $nothelpful = '';

    /**
     * Additional tt_content for Answer
     *
     * @Cascade("remove")
     * @Lazy
     *
     * @var ObjectStorage<TtContent>
     */
    protected $additionalContentAnswer;

    /**
     * categories
     *
     * @var ObjectStorage<Category>
     */
    protected $categories = null;

    /**
     * comments
     *
     * @Cascade("remove")
     * @Lazy
     *
     * @var ObjectStorage<Questioncomment>
     */
    protected $questioncomment = null;

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->categories = new ObjectStorage();
        $this->additionalContentAnswer = new ObjectStorage();
        $this->questioncomment = new ObjectStorage();
    }

    /**
     * Returns the question
     *
     * @return string $question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Sets the question
     *
     * @param string $question
     * @return void
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * Returns the answer
     *
     * @return string $answer
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Sets the answer
     *
     * @param string $answer
     * @return void
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
    }

    /**
     * Get content elements (additionalContentAnswer)
     *
     * @return ObjectStorage<TtContent> $additionalContentAnswer
     */
    public function getAdditionalContentAnswer()
    {
        return $this->additionalContentAnswer;
    }

    /**
     * Get id list of content elements (additionalContentAnswer)
     *
     * @return string
     */
    public function getContentElementIdList()
    {
        $idList = [];
        $contentElements = $this->getAdditionalContentAnswer();
        if ($contentElements) {
            foreach ($this->getAdditionalContentAnswer() as $contentElement) {
                $idList[] = $contentElement->getUid();
            }
        }
        return implode(',', $idList);
    }

    /**
     * Adds a Category
     *
     * @param Category $category
     * @return void
     */
    public function addCategory(Category $category)
    {
        $this->categories->attach($category);
    }

    /**
     * Removes a Category
     *
     * @param Category $categoryToRemove The Category to be removed
     * @return void
     */
    public function removeCategory(Category $categoryToRemove)
    {
        $this->categories->detach($categoryToRemove);
    }

    /**
     * Returns the categories
     *
     * @return ObjectStorage<Category> $categories
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Sets the categories
     *
     * @param ObjectStorage<Category> $categories
     * @return void
     */
    public function setCategories(ObjectStorage $categories)
    {
        $this->categories = $categories;
    }

    /**
     * Returns the Helpful
     *
     * @return int
     */
    public function getHelpful()
    {
        return $this->helpful;
    }

    /**
     * Sets the Helpful
     *
     * @param int $helpful
     * @return void
     */
    public function setHelpful($helpful)
    {
        $this->helpful = $helpful;
    }

    /**
     * Returns the Nothelpful
     *
     * @return int
     */
    public function getNothelpful()
    {
        return $this->nothelpful;
    }

    /**
     * Sets the Nothelpful
     *
     * @param int $nothelpful
     * @return void
     */
    public function setNothelpful($nothelpful)
    {
        $this->nothelpful = $nothelpful;
    }

    /**
     * Returns the Questioncomment
     *
     * @return ObjectStorage<Questioncomment>
     */
    public function getQuestioncomment()
    {
        return $this->questioncomment;
    }

    /**
     * Adds a questioncomment
     *
     * @param Questioncomment $questioncomment
     * @return void
     */
    public function addComment(Questioncomment $questioncomment)
    {
        $this->questioncomment->attach($questioncomment);
    }
}
