<?php

namespace cubes\content\staticBlock\repository;

use cubes\content\staticBlock\StaticBlockFactory;
use Doctrine\DBAL\Connection;
use WebComplete\core\condition\ConditionDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryDb;

class StaticBlockRepositoryDb extends AbstractEntityRepositoryDb implements StaticBlockRepositoryInterface
{

    protected $table = 'static_block';
    protected $serializeFields = ['multilang'];

    public function __construct(
        StaticBlockFactory $factory,
        ConditionDbParser $conditionParser,
        Connection $db
    ) {
        parent::__construct($factory, $conditionParser, $db);
    }
}
