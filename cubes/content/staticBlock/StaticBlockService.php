<?php

namespace cubes\content\staticBlock;

use WebComplete\core\entity\AbstractEntityService;

class StaticBlockService extends AbstractEntityService implements StaticBlockRepositoryInterface
{

    /**
     * @var StaticBlockRepositoryInterface
     */
    protected $repository;

    /**
     * @param StaticBlockRepositoryInterface $repository
     */
    public function __construct(StaticBlockRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
