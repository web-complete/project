<?php

namespace cubes\content\staticBlock\repository;

use cubes\content\staticBlock\StaticBlockFactory;
use cubes\system\mongo\AbstractEntityRepositoryMongo;
use cubes\system\mongo\ConditionMongoDbParser;
use cubes\system\mongo\Mongo;

class StaticBlockRepositoryMongo extends AbstractEntityRepositoryMongo implements StaticBlockRepositoryInterface
{

    protected $collectionName = 'static_block';

    public function __construct(
        StaticBlockFactory $factory,
        Mongo $mongo,
        ConditionMongoDbParser $conditionParser
    ) {
        parent::__construct($factory, $mongo, $conditionParser);
    }
}
