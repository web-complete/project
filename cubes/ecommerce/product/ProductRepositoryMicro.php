<?php

namespace cubes\ecommerce\product;

use WebComplete\core\condition\ConditionMicroDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryMicro;
use WebComplete\microDb\MicroDb;

class ProductRepositoryMicro extends AbstractEntityRepositoryMicro implements ProductRepositoryInterface
{

    protected $collectionName = 'product';

    /**
     * @param ProductFactory $factory
     * @param MicroDb $microDb
     * @param ConditionMicroDbParser $conditionParser
     */
    public function __construct(
        ProductFactory $factory,
        MicroDb $microDb,
        ConditionMicroDbParser $conditionParser
    ) {
        parent::__construct($factory, $microDb, $conditionParser);
    }
}
