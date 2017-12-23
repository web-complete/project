<?php

namespace cubes\content\article;

use WebComplete\core\entity\AbstractEntityService;
use WebComplete\core\utils\event\EventService;

class ArticleService extends AbstractEntityService implements ArticleRepositoryInterface
{

    /**
     * @var ArticleRepositoryInterface
     */
    protected $repository;

    /**
     * @param ArticleRepositoryInterface $repository
     * @param EventService $eventService
     */
    public function __construct(ArticleRepositoryInterface $repository, EventService $eventService)
    {
        parent::__construct($repository, $eventService);
    }

    /**
     * @param Article $item
     *
     * @return Article|null
     */
    public function findPrev(Article $item)
    {
        return $this->findPrevNext($item, \SORT_DESC);
    }

    /**
     * @param Article $item
     *
     * @return Article|null
     */
    public function findNext(Article $item)
    {
        return $this->findPrevNext($item, \SORT_ASC);
    }

    /**
     * @param Article $item
     * @param int $sortDir
     *
     * @return null|\WebComplete\core\entity\AbstractEntity|Article
     */
    protected function findPrevNext(Article $item, int $sortDir)
    {
        $result = null;
        $sortField = 'published_on';
        $condition = $this->createCondition();
        $condition->addEqualsCondition('is_active', 1);
        if ($value = $item->get($sortField)) {
            $condition
                ->setSort($sortField, $sortDir)
                ->limit(1);

            ($sortDir === \SORT_DESC)
                ? $condition->addLessThanCondition($sortField, $value)
                : $condition->addGreaterThanCondition($sortField, $value);

            return $this->findOne($condition);
        }
        return $result;
    }
}
