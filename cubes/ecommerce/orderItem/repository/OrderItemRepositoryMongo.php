<?php

namespace cubes\ecommerce\orderItem\repository;

use cubes\ecommerce\order\OrderFactory;
use cubes\ecommerce\order\repository\OrderRepositoryInterface;
use cubes\system\mongo\AbstractEntityRepositoryMongo;
use cubes\system\mongo\ConditionMongoDbParser;
use cubes\system\mongo\Mongo;

class OrderItemRepositoryMongo extends AbstractEntityRepositoryMongo implements OrderRepositoryInterface
{

    protected $collectionName = 'order_item';

    public function __construct(
        OrderFactory $factory,
        Mongo $mongo,
        ConditionMongoDbParser $conditionParser
    ) {
        parent::__construct($factory, $mongo, $conditionParser);
    }
}
