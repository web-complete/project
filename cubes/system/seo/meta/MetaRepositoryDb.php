<?php

namespace cubes\system\seo\meta;

use Doctrine\DBAL\Connection;
use WebComplete\core\condition\ConditionDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryDb;

class MetaRepositoryDb extends AbstractEntityRepositoryDb implements MetaRepositoryInterface
{

    protected $table = 'meta';

    /**
     * @param MetaFactory $factory
     * @param ConditionDbParser $conditionParser
     * @param Connection $db
     */
    public function __construct(
        MetaFactory $factory,
        ConditionDbParser $conditionParser,
        Connection $db
    ) {
        parent::__construct($factory, $conditionParser, $db);
    }
}
