<?php

namespace cubes\system\seo\redirect;

use WebComplete\core\condition\ConditionMicroDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryMicro;
use WebComplete\microDb\MicroDb;

class RedirectRepositoryMicro extends AbstractEntityRepositoryMicro implements RedirectRepositoryInterface
{

    protected $collectionName = 'redirect';

    /**
     * @param RedirectFactory $factory
     * @param MicroDb $microDb
     * @param ConditionMicroDbParser $conditionParser
     */
    public function __construct(
        RedirectFactory $factory,
        MicroDb $microDb,
        ConditionMicroDbParser $conditionParser
    ) {
        parent::__construct($factory, $microDb, $conditionParser);
    }
}
