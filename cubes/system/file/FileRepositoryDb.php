<?php

namespace cubes\system\file;

use Doctrine\DBAL\Connection;
use WebComplete\core\condition\ConditionDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryDb;
use WebComplete\core\factory\EntityFactory;

class FileRepositoryDb extends AbstractEntityRepositoryDb implements FileRepositoryInterface
{

    protected $table = 'file';
    protected $serializeFields = ['data'];

    /**
     * @param FileFactory $factory
     * @param ConditionDbParser $conditionParser
     * @param Connection $db
     */
    public function __construct(
        FileFactory $factory,
        ConditionDbParser $conditionParser,
        Connection $db
    ) {
        parent::__construct($factory, $conditionParser, $db);
    }
}
