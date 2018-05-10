<?php

namespace cubes\ecommerce\productOffer\repository;

use cubes\ecommerce\productOffer\ProductOfferFactory;
use WebComplete\core\condition\ConditionMicroDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryMicro;
use WebComplete\microDb\MicroDb;

class ProductOfferRepositoryMicro extends AbstractEntityRepositoryMicro implements
    ProductOfferRepositoryInterface
{

    protected $collectionName = 'product_offer';

    /**
     * @param ProductOfferFactory    $factory
     * @param MicroDb                $microDb
     * @param ConditionMicroDbParser $conditionParser
     */
    public function __construct(
        ProductOfferFactory $factory,
        MicroDb $microDb,
        ConditionMicroDbParser $conditionParser
    ) {
        parent::__construct($factory, $microDb, $conditionParser);
    }
}
