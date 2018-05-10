<?php

namespace cubes\ecommerce\cart\repository;

use cubes\ecommerce\cart\CartFactory;
use cubes\system\mongo\AbstractEntityRepositoryMongo;
use cubes\system\mongo\ConditionMongoDbParser;
use cubes\system\mongo\Mongo;

class CartRepositoryMongo extends AbstractEntityRepositoryMongo implements CartRepositoryInterface
{

    protected $collectionName = 'cart';

    /**
     * @param CartFactory $factory
     * @param Mongo $microDb
     * @param ConditionMongoDbParser $conditionParser
     */
    public function __construct(
        CartFactory $factory,
        Mongo $mongo,
        ConditionMongoDbParser $conditionParser
    ) {
        parent::__construct($factory, $mongo, $conditionParser);
    }
}
