<?php

namespace cubes\ecommerce\order;

use Doctrine\DBAL\Connection;
use WebComplete\core\condition\ConditionDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryDb;

class OrderRepositoryDb extends AbstractEntityRepositoryDb implements OrderRepositoryInterface
{

    protected $table = 'order';

    /**
     * @param OrderFactory $factory
     * @param ConditionDbParser $conditionParser
     * @param Connection $db
     */
    public function __construct(
        OrderFactory $factory,
        ConditionDbParser $conditionParser,
        Connection $db
    ) {
        parent::__construct($factory, $conditionParser, $db);
    }
}
