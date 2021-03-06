<?php

namespace cubes\system\seo\slug;

use cubes\system\seo\slug\repository\SlugRepositoryInterface;
use WebComplete\core\entity\AbstractEntityService;

class SlugService extends AbstractEntityService implements SlugRepositoryInterface
{

    /**
     * @var SlugRepositoryInterface
     */
    protected $repository;

    /**
     * @param SlugRepositoryInterface $repository
     */
    public function __construct(SlugRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
