<?php

namespace cubes\system\storage\repository;

use cubes\system\storage\StorageFactory;
use WebComplete\core\condition\ConditionMicroDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryMicro;
use WebComplete\microDb\MicroDb;

class StorageRepositoryMicro extends AbstractEntityRepositoryMicro implements StorageRepositoryInterface
{

    protected $collectionName = 'storage';

    /**
     * @param StorageFactory $factory
     * @param MicroDb $microDb
     * @param ConditionMicroDbParser $conditionParser
     */
    public function __construct(
        StorageFactory $factory,
        MicroDb $microDb,
        ConditionMicroDbParser $conditionParser
    ) {
        parent::__construct($factory, $microDb, $conditionParser);
    }
}
