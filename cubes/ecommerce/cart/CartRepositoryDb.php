<?php

namespace cubes\ecommerce\cart;

use Doctrine\DBAL\Connection;
use WebComplete\core\condition\ConditionDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryDb;

class CartRepositoryDb extends AbstractEntityRepositoryDb implements CartRepositoryInterface
{

    protected $table = 'cart';

    /**
     * @param CartFactory $factory
     * @param ConditionDbParser $conditionParser
     * @param Connection $db
     */
    public function __construct(
        CartFactory $factory,
        ConditionDbParser $conditionParser,
        Connection $db
    ) {
        parent::__construct($factory, $conditionParser, $db);
    }
}
