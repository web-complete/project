<?php

namespace cubes\content\staticPage;

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
