<?php

namespace cubes\ecommerce\product\repository;

use cubes\ecommerce\product\ProductFactory;
use Doctrine\DBAL\Connection;
use WebComplete\core\condition\ConditionDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryDb;

class ProductRepositoryDb extends AbstractEntityRepositoryDb implements ProductRepositoryInterface
{

    protected $table = 'product';

    protected $serializeFields = ['multilang', 'properties', 'properties_multilang'];

    /**
     * @param ProductFactory $factory
     * @param ConditionDbParser $conditionParser
     * @param Connection $db
     */
    public function __construct(
        ProductFactory $factory,
        ConditionDbParser $conditionParser,
        Connection $db
    ) {
        parent::__construct($factory, $conditionParser, $db);
    }
}
