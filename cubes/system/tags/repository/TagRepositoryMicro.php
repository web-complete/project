<?php

namespace cubes\system\tags\repository;

use cubes\system\tags\TagFactory;
use WebComplete\core\condition\ConditionMicroDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryMicro;
use WebComplete\microDb\MicroDb;

class TagRepositoryMicro extends AbstractEntityRepositoryMicro implements TagRepositoryInterface
{

    protected $collectionName = 'tag';

    public function __construct(
        TagFactory $factory,
        MicroDb $microDb,
        ConditionMicroDbParser $conditionParser
    ) {
        parent::__construct($factory, $microDb, $conditionParser);
    }
}
