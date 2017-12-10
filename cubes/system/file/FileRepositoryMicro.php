<?php

namespace cubes\system\file;

use WebComplete\core\condition\ConditionMicroDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryMicro;
use WebComplete\microDb\MicroDb;

class FileRepositoryMicro extends AbstractEntityRepositoryMicro implements FileRepositoryInterface
{
    protected $collectionName = 'file';

    /**
     * @param FileFactory $factory
     * @param MicroDb $microDb
     * @param ConditionMicroDbParser $conditionParser
     */
    public function __construct(
        FileFactory $factory,
        MicroDb $microDb,
        ConditionMicroDbParser $conditionParser
    ) {
        parent::__construct($factory, $microDb, $conditionParser);
    }

}
