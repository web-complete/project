<?php

namespace cubes\system\seo\slug\repository;

use cubes\system\mongo\AbstractEntityRepositoryMongo;
use cubes\system\mongo\ConditionMongoDbParser;
use cubes\system\mongo\Mongo;
use cubes\system\seo\slug\SlugFactory;

class SlugRepositoryMongo extends AbstractEntityRepositoryMongo implements SlugRepositoryInterface
{

    protected $collectionName = 'slug';

    public function __construct(
        SlugFactory $factory,
        Mongo $mongo,
        ConditionMongoDbParser $conditionParser
    ) {
        parent::__construct($factory, $mongo, $conditionParser);
    }
}
