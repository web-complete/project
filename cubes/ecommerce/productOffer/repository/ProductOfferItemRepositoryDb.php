<?php

namespace cubes\ecommerce\productOffer\repository;

use cubes\ecommerce\productOffer\ProductOfferItemFactory;
use Doctrine\DBAL\Connection;
use WebComplete\core\condition\ConditionDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryDb;

class ProductOfferItemRepositoryDb extends AbstractEntityRepositoryDb implements ProductOfferItemRepositoryInterface
{

    protected $table = 'product_offer';

    protected $serializeFields = ['multilang', 'properties', 'properties_multilang'];

    /**
     * @param ProductOfferItemFactory $factory
     * @param ConditionDbParser $conditionParser
     * @param Connection $db
     */
    public function __construct(
        ProductOfferItemFactory $factory,
        ConditionDbParser $conditionParser,
        Connection $db
    ) {
        parent::__construct($factory, $conditionParser, $db);
    }
}
