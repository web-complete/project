<?php

namespace cubes\ecommerce\classifier\repository;

use cubes\ecommerce\classifier\ClassifierItemFactory;
use cubes\system\mongo\AbstractEntityRepositoryMongo;
use cubes\system\mongo\ConditionMongoDbParser;
use cubes\system\mongo\Mongo;

class ClassifierItemRepositoryMongo extends AbstractEntityRepositoryMongo implements ClassifierItemRepositoryInterface
{

    protected $collectionName = 'classifier';

    public function __construct(
        ClassifierItemFactory $factory,
        Mongo $mongo,
        ConditionMongoDbParser $conditionParser
    ) {
        parent::__construct($factory, $mongo, $conditionParser);
    }
}
