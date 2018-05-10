<?php

namespace cubes\system\multilang\translation\repository;

use cubes\system\multilang\translation\TranslationFactory;
use Doctrine\DBAL\Connection;
use WebComplete\core\condition\ConditionDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryDb;

class TranslationRepositoryDb extends AbstractEntityRepositoryDb implements TranslationRepositoryInterface
{

    protected $table = 'translation';
    protected $serializeFields = ['translations'];

    /**
     * @param TranslationFactory $factory
     * @param ConditionDbParser $conditionParser
     * @param Connection $db
     */
    public function __construct(
        TranslationFactory $factory,
        ConditionDbParser $conditionParser,
        Connection $db
    ) {
        parent::__construct($factory, $conditionParser, $db);
    }
}
