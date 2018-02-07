<?php

namespace cubes\ecommerce\order;

use WebComplete\core\condition\ConditionMicroDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryMicro;
use WebComplete\microDb\MicroDb;

class OrderRepositoryMicro extends AbstractEntityRepositoryMicro implements OrderRepositoryInterface
{

    protected $collectionName = 'order';

    /**
     * @param OrderFactory $factory
     * @param MicroDb $microDb
     * @param ConditionMicroDbParser $conditionParser
     */
    public function __construct(
        OrderFactory $factory,
        MicroDb $microDb,
        ConditionMicroDbParser $conditionParser
    ) {
        parent::__construct($factory, $microDb, $conditionParser);
    }
}
