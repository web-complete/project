<?php

namespace cubes\system\storage;

use Doctrine\DBAL\Connection;
use WebComplete\core\condition\ConditionDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryDb;

class StorageRepositoryDb extends AbstractEntityRepositoryDb implements StorageRepositoryInterface
{

    protected $table = 'storage';

    /**
     * @param StorageFactory $factory
     * @param ConditionDbParser $conditionParser
     * @param Connection $db
     */
    public function __construct(
        StorageFactory $factory,
        ConditionDbParser $conditionParser,
        Connection $db
    ) {
        parent::__construct($factory, $conditionParser, $db);
    }
}
