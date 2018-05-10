<?php

namespace cubes\ecommerce\productOffer\repository;

use cubes\ecommerce\productOffer\ProductOfferItemFactory;
use WebComplete\core\condition\ConditionMicroDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryMicro;
use WebComplete\microDb\MicroDb;

class ProductOfferItemRepositoryMicro extends AbstractEntityRepositoryMicro implements
    ProductOfferItemRepositoryInterface
{

    protected $collectionName = 'product_offer';

    /**
     * @param ProductOfferItemFactory $factory
     * @param MicroDb $microDb
     * @param ConditionMicroDbParser $conditionParser
     */
    public function __construct(
        ProductOfferItemFactory $factory,
        MicroDb $microDb,
        ConditionMicroDbParser $conditionParser
    ) {
        parent::__construct($factory, $microDb, $conditionParser);
    }
}
