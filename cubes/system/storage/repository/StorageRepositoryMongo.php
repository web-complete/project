<?php

namespace cubes\system\storage\repository;

use cubes\system\mongo\AbstractEntityRepositoryMongo;
use cubes\system\mongo\ConditionMongoDbParser;
use cubes\system\mongo\Mongo;
use cubes\system\storage\StorageFactory;

class StorageRepositoryMongo extends AbstractEntityRepositoryMongo implements StorageRepositoryInterface
{

    protected $collectionName = 'storage';

    public function __construct(
        StorageFactory $factory,
        Mongo $mongo,
        ConditionMongoDbParser $conditionParser
    ) {
        parent::__construct($factory, $mongo, $conditionParser);
    }
}
