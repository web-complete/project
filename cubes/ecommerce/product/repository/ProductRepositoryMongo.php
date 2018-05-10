<?php

namespace cubes\ecommerce\product\repository;

use cubes\ecommerce\product\ProductFactory;
use cubes\system\mongo\AbstractEntityRepositoryMongo;
use cubes\system\mongo\ConditionMongoDbParser;
use cubes\system\mongo\Mongo;

class ProductRepositoryMongo extends AbstractEntityRepositoryMongo implements ProductRepositoryInterface
{

    protected $collectionName = 'product';

    public function __construct(
        ProductFactory $factory,
        Mongo $mongo,
        ConditionMongoDbParser $conditionParser
    ) {
        parent::__construct($factory, $mongo, $conditionParser);
    }
}
