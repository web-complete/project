<?php

namespace cubes\system\multilang\lang\repository;

use cubes\system\multilang\lang\LangFactory;
use Doctrine\DBAL\Connection;
use WebComplete\core\condition\ConditionDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryDb;

class LangRepositoryDb extends AbstractEntityRepositoryDb implements LangRepositoryInterface
{

    protected $table = 'lang';

    /**
     * @param LangFactory $factory
     * @param ConditionDbParser $conditionParser
     * @param Connection $db
     */
    public function __construct(
        LangFactory $factory,
        ConditionDbParser $conditionParser,
        Connection $db
    ) {
        parent::__construct($factory, $conditionParser, $db);
    }
}
