<?php

namespace cubes\content\staticPage;

use cubes\content\staticPage\repository\StaticPageRepositoryInterface;
use WebComplete\core\entity\AbstractEntityService;

class StaticPageService extends AbstractEntityService implements StaticPageRepositoryInterface
{

    /**
     * @var StaticPageRepositoryInterface
     */
    protected $repository;

    /**
     * @param StaticPageRepositoryInterface $repository
     */
    public function __construct(StaticPageRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
