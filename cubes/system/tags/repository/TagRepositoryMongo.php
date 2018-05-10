<?php

namespace cubes\system\tags\repository;

use cubes\system\mongo\AbstractEntityRepositoryMongo;
use cubes\system\mongo\ConditionMongoDbParser;
use cubes\system\mongo\Mongo;
use cubes\system\tags\TagFactory;

class TagRepositoryMongo extends AbstractEntityRepositoryMongo implements TagRepositoryInterface
{

    protected $collectionName = 'tag';

    public function __construct(
        TagFactory $factory,
        Mongo $mongo,
        ConditionMongoDbParser $conditionParser
    ) {
        parent::__construct($factory, $mongo, $conditionParser);
    }
}
