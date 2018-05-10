<?php

namespace cubes\system\storage;

use cubes\system\storage\repository\StorageRepositoryInterface;
use WebComplete\core\entity\AbstractEntityService;

class StorageService extends AbstractEntityService implements StorageRepositoryInterface
{

    /**
     * @var StorageRepositoryInterface
     */
    protected $repository;

    /**
     * @param StorageRepositoryInterface $repository
     */
    public function __construct(StorageRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
