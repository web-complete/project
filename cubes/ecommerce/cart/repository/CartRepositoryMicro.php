<?php

namespace cubes\ecommerce\cart\repository;

use cubes\ecommerce\cart\CartFactory;
use WebComplete\core\condition\ConditionMicroDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryMicro;
use WebComplete\microDb\MicroDb;

class CartRepositoryMicro extends AbstractEntityRepositoryMicro implements CartRepositoryInterface
{

    protected $collectionName = 'cart';

    /**
     * @param CartFactory $factory
     * @param MicroDb $microDb
     * @param ConditionMicroDbParser $conditionParser
     */
    public function __construct(
        CartFactory $factory,
        MicroDb $microDb,
        ConditionMicroDbParser $conditionParser
    ) {
        parent::__construct($factory, $microDb, $conditionParser);
    }
}
