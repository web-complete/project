<?php

namespace cubes\ecommerce\cartItem\repository;

use cubes\ecommerce\cartItem\CartItemFactory;
use cubes\system\mongo\AbstractEntityRepositoryMongo;
use cubes\system\mongo\ConditionMongoDbParser;
use cubes\system\mongo\Mongo;

class CartItemRepositoryMongo extends AbstractEntityRepositoryMongo implements CartItemRepositoryInterface
{

    protected $collectionName = 'cart_item';

    /**
     * @param CartItemFactory $factory
     * @param Mongo $microDb
     * @param ConditionMongoDbParser $conditionParser
     */
    public function __construct(
        CartItemFactory $factory,
        Mongo $mongo,
        ConditionMongoDbParser $conditionParser
    ) {
        parent::__construct($factory, $mongo, $conditionParser);
    }
}
