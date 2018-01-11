<?php

namespace cubes\multilang\lang;

use WebComplete\core\condition\ConditionMicroDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryMicro;
use WebComplete\microDb\MicroDb;

class LangRepositoryMicro extends AbstractEntityRepositoryMicro implements LangRepositoryInterface
{

    protected $collectionName = 'lang';

    /**
     * @param LangFactory $factory
     * @param MicroDb $microDb
     * @param ConditionMicroDbParser $conditionParser
     */
    public function __construct(
        LangFactory $factory,
        MicroDb $microDb,
        ConditionMicroDbParser $conditionParser
    ) {
        parent::__construct($factory, $microDb, $conditionParser);
    }
}
