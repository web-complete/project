<?php

namespace cubes\ecommerce\cartItem;

use Doctrine\DBAL\Connection;
use WebComplete\core\condition\ConditionDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryDb;

class CartItemRepositoryDb extends AbstractEntityRepositoryDb implements CartItemRepositoryInterface
{

    protected $table = 'cart_item';

    /**
     * @param CartItemFactory $factory
     * @param ConditionDbParser $conditionParser
     * @param Connection $db
     */
    public function __construct(
        CartItemFactory $factory,
        ConditionDbParser $conditionParser,
        Connection $db
    ) {
        parent::__construct($factory, $conditionParser, $db);
    }
}
