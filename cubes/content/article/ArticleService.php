<?php

namespace cubes\content\article;

use WebComplete\core\entity\AbstractEntityService;

class ArticleService extends AbstractEntityService implements ArticleRepositoryInterface
{

    /**
     * @var ArticleRepositoryInterface
     */
    protected $repository;

    /**
     * @param ArticleRepositoryInterface $repository
     */
    public function __construct(ArticleRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
