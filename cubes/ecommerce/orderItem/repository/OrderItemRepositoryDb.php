<?php

namespace cubes\ecommerce\orderItem\repository;

use cubes\ecommerce\orderItem\OrderItemFactory;
use Doctrine\DBAL\Connection;
use WebComplete\core\condition\ConditionDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryDb;

class OrderItemRepositoryDb extends AbstractEntityRepositoryDb implements OrderItemRepositoryInterface
{

    protected $table = 'order_item';

    /**
     * @param OrderItemFactory $factory
     * @param ConditionDbParser $conditionParser
     * @param Connection $db
     */
    public function __construct(
        OrderItemFactory $factory,
        ConditionDbParser $conditionParser,
        Connection $db
    ) {
        parent::__construct($factory, $conditionParser, $db);
    }
}
