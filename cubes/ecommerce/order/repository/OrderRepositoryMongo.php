<?php

namespace cubes\ecommerce\order\repository;

use cubes\ecommerce\order\OrderFactory;
use cubes\system\mongo\AbstractEntityRepositoryMongo;
use cubes\system\mongo\ConditionMongoDbParser;
use cubes\system\mongo\Mongo;

class OrderRepositoryMongo extends AbstractEntityRepositoryMongo implements OrderRepositoryInterface
{

    protected $collectionName = 'order';

    public function __construct(
        OrderFactory $factory,
        Mongo $mongo,
        ConditionMongoDbParser $conditionParser
    ) {
        parent::__construct($factory, $mongo, $conditionParser);
    }
}
