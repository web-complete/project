<?php

namespace cubes\ecommerce\classifier\repository;

use cubes\ecommerce\classifier\ClassifierItemFactory;
use WebComplete\core\condition\ConditionMicroDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryMicro;
use WebComplete\microDb\MicroDb;

class ClassifierItemRepositoryMicro extends AbstractEntityRepositoryMicro implements ClassifierItemRepositoryInterface
{

    protected $collectionName = 'classifier';

    /**
     * @param ClassifierItemFactory $factory
     * @param MicroDb $microDb
     * @param ConditionMicroDbParser $conditionParser
     */
    public function __construct(
        ClassifierItemFactory $factory,
        MicroDb $microDb,
        ConditionMicroDbParser $conditionParser
    ) {
        parent::__construct($factory, $microDb, $conditionParser);
    }
}
