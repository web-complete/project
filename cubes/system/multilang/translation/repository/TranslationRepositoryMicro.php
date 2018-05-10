<?php

namespace cubes\system\multilang\translation\repository;

use cubes\system\multilang\translation\TranslationFactory;
use WebComplete\core\condition\ConditionMicroDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryMicro;
use WebComplete\microDb\MicroDb;

class TranslationRepositoryMicro extends AbstractEntityRepositoryMicro implements TranslationRepositoryInterface
{

    protected $collectionName = 'translation';

    /**
     * @param TranslationFactory $factory
     * @param MicroDb $microDb
     * @param ConditionMicroDbParser $conditionParser
     */
    public function __construct(
        TranslationFactory $factory,
        MicroDb $microDb,
        ConditionMicroDbParser $conditionParser
    ) {
        parent::__construct($factory, $microDb, $conditionParser);
    }
}
