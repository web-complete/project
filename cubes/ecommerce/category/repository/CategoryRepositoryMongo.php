<?php

namespace cubes\ecommerce\category\repository;

use cubes\ecommerce\category\CategoryFactory;
use cubes\system\mongo\AbstractEntityRepositoryMongo;
use cubes\system\mongo\ConditionMongoDbParser;
use cubes\system\mongo\Mongo;

class CategoryRepositoryMongo extends AbstractEntityRepositoryMongo implements CategoryRepositoryInterface
{

    protected $collectionName = 'category';

    public function __construct(
        CategoryFactory $factory,
        Mongo $mongo,
        ConditionMongoDbParser $conditionParser
    ) {
        parent::__construct($factory, $mongo, $conditionParser);
    }
}
