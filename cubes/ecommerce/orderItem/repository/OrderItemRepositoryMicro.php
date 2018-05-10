<?php

namespace cubes\ecommerce\orderItem\repository;

use cubes\ecommerce\orderItem\OrderItemFactory;
use WebComplete\core\condition\ConditionMicroDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryMicro;
use WebComplete\microDb\MicroDb;

class OrderItemRepositoryMicro extends AbstractEntityRepositoryMicro implements OrderItemRepositoryInterface
{

    protected $collectionName = 'order_item';

    /**
     * @param OrderItemFactory $factory
     * @param MicroDb $microDb
     * @param ConditionMicroDbParser $conditionParser
     */
    public function __construct(
        OrderItemFactory $factory,
        MicroDb $microDb,
        ConditionMicroDbParser $conditionParser
    ) {
        parent::__construct($factory, $microDb, $conditionParser);
    }
}
