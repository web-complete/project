<?php

namespace cubes\content\staticPage\repository;

use cubes\content\staticPage\StaticPageFactory;
use Doctrine\DBAL\Connection;
use WebComplete\core\condition\ConditionDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryDb;

class StaticPageRepositoryDb extends AbstractEntityRepositoryDb implements StaticPageRepositoryInterface
{

    protected $table = 'static_page';

    /**
     * @param StaticPageFactory $factory
     * @param ConditionDbParser $conditionParser
     * @param Connection $db
     */
    public function __construct(
        StaticPageFactory $factory,
        ConditionDbParser $conditionParser,
        Connection $db
    ) {
        parent::__construct($factory, $conditionParser, $db);
    }
}
