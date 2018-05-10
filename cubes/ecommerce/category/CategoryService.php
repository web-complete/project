<?php

namespace cubes\ecommerce\category;

use cubes\ecommerce\category\repository\CategoryRepositoryInterface;
use WebComplete\core\entity\AbstractEntityService;

class CategoryService extends AbstractEntityService implements CategoryRepositoryInterface
{

    /**
     * @var CategoryRepositoryInterface
     */
    protected $repository;

    /**
     * @param CategoryRepositoryInterface $repository
     */
    public function __construct(CategoryRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
