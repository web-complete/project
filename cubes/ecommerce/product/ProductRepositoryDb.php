<?php

namespace cubes\ecommerce\product;

use Doctrine\DBAL\Connection;
use WebComplete\core\condition\ConditionDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryDb;

class ProductRepositoryDb extends AbstractEntityRepositoryDb implements ProductRepositoryInterface
{

    protected $table = 'product';

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
