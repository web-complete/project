<?php

namespace cubes\content\staticBlock;

use WebComplete\core\condition\ConditionMicroDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryMicro;
use WebComplete\microDb\MicroDb;

class StaticBlockRepositoryMicro extends AbstractEntityRepositoryMicro implements StaticBlockRepositoryInterface
{

    protected $collectionName = 'static_block';

    public function __construct(
        StaticBlockFactory $factory,
        MicroDb $microDb,
        ConditionMicroDbParser $conditionParser
    ) {
        parent::__construct($factory, $microDb, $conditionParser);
    }
}
