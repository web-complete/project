<?php

namespace cubes\ecommerce\productOffer\repository;

use cubes\ecommerce\productOffer\ProductOfferFactory;
use cubes\system\mongo\AbstractEntityRepositoryMongo;
use cubes\system\mongo\ConditionMongoDbParser;
use cubes\system\mongo\Mongo;

class ProductOfferRepositoryMongo extends AbstractEntityRepositoryMongo implements ProductOfferRepositoryInterface
{

    protected $collectionName = 'product_offer';

    public function __construct(
        ProductOfferFactory $factory,
        Mongo $mongo,
        ConditionMongoDbParser $conditionParser
    ) {
        parent::__construct($factory, $mongo, $conditionParser);
    }
}
