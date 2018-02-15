<?php

namespace cubes\system\seo\redirect;

use Doctrine\DBAL\Connection;
use WebComplete\core\condition\ConditionDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryDb;

class RedirectRepositoryDb extends AbstractEntityRepositoryDb implements RedirectRepositoryInterface
{

    protected $table = 'redirect';

    /**
     * @param RedirectFactory $factory
     * @param ConditionDbParser $conditionParser
     * @param Connection $db
     */
    public function __construct(
        RedirectFactory $factory,
        ConditionDbParser $conditionParser,
        Connection $db
    ) {
        parent::__construct($factory, $conditionParser, $db);
    }
}
