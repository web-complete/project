<?php

namespace cubes\ecommerce\cartItem;

use WebComplete\core\condition\ConditionMicroDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryMicro;
use WebComplete\microDb\MicroDb;

class CartItemRepositoryMicro extends AbstractEntityRepositoryMicro implements CartItemRepositoryInterface
{

    protected $collectionName = 'cart_item';

    /**
     * @param CartItemFactory $factory
     * @param MicroDb $microDb
     * @param ConditionMicroDbParser $conditionParser
     */
    public function __construct(
        CartItemFactory $factory,
        MicroDb $microDb,
        ConditionMicroDbParser $conditionParser
    ) {
        parent::__construct($factory, $microDb, $conditionParser);
    }
}
