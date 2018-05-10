<?php

namespace cubes\ecommerce\productOffer\repository;

use cubes\ecommerce\productOffer\ProductOfferFactory;
use Doctrine\DBAL\Connection;
use WebComplete\core\condition\ConditionDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryDb;

class ProductOfferRepositoryDb extends AbstractEntityRepositoryDb implements ProductOfferRepositoryInterface
{

    protected $table = 'product_offer';

    protected $serializeFields = ['multilang', 'properties', 'properties_multilang'];

    /**
     * @param ProductOfferFactory $factory
     * @param ConditionDbParser   $conditionParser
     * @param Connection          $db
     */
    public function __construct(
        ProductOfferFactory $factory,
        ConditionDbParser $conditionParser,
        Connection $db
    ) {
        parent::__construct($factory, $conditionParser, $db);
    }
}
