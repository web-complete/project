<?php

namespace cubes\ecommerce\productOffer\repository;

use cubes\ecommerce\productOffer\ProductOfferItemFactory;
use cubes\system\mongo\AbstractEntityRepositoryMongo;
use cubes\system\mongo\ConditionMongoDbParser;
use cubes\system\mongo\Mongo;

class ProductOfferItemRepositoryMongo extends AbstractEntityRepositoryMongo implements ProductOfferItemRepositoryInterface
{

    protected $collectionName = 'product_offer';

    public function __construct(
        ProductOfferItemFactory $factory,
        Mongo $mongo,
        ConditionMongoDbParser $conditionParser
    ) {
        parent::__construct($factory, $mongo, $conditionParser);
    }
}
