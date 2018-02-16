<?php

namespace cubes\ecommerce\category;

use WebComplete\core\condition\ConditionMicroDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryMicro;
use WebComplete\microDb\MicroDb;

class CategoryRepositoryMicro extends AbstractEntityRepositoryMicro implements CategoryRepositoryInterface
{

    protected $collectionName = 'category';

    /**
     * @param CategoryFactory $factory
     * @param MicroDb $microDb
     * @param ConditionMicroDbParser $conditionParser
     */
    public function __construct(
        CategoryFactory $factory,
        MicroDb $microDb,
        ConditionMicroDbParser $conditionParser
    ) {
        parent::__construct($factory, $microDb, $conditionParser);
    }
}
