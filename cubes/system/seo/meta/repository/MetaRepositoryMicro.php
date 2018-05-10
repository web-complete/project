<?php

namespace cubes\system\seo\meta\repository;

use cubes\system\seo\meta\MetaFactory;
use WebComplete\core\condition\ConditionMicroDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryMicro;
use WebComplete\microDb\MicroDb;

class MetaRepositoryMicro extends AbstractEntityRepositoryMicro implements MetaRepositoryInterface
{

    protected $collectionName = 'meta';

    /**
     * @param MetaFactory $factory
     * @param MicroDb $microDb
     * @param ConditionMicroDbParser $conditionParser
     */
    public function __construct(
        MetaFactory $factory,
        MicroDb $microDb,
        ConditionMicroDbParser $conditionParser
    ) {
        parent::__construct($factory, $microDb, $conditionParser);
    }
}
