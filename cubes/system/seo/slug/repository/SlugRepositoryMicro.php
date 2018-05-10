<?php

namespace cubes\system\seo\slug\repository;

use cubes\system\seo\slug\SlugFactory;
use WebComplete\core\condition\ConditionMicroDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryMicro;
use WebComplete\microDb\MicroDb;

class SlugRepositoryMicro extends AbstractEntityRepositoryMicro implements SlugRepositoryInterface
{

    protected $collectionName = 'slug';

    /**
     * @param SlugFactory $factory
     * @param MicroDb $microDb
     * @param ConditionMicroDbParser $conditionParser
     */
    public function __construct(
        SlugFactory $factory,
        MicroDb $microDb,
        ConditionMicroDbParser $conditionParser
    ) {
        parent::__construct($factory, $microDb, $conditionParser);
    }
}
