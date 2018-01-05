<?php

namespace cubes\content\staticBlock;

use Doctrine\DBAL\Connection;
use WebComplete\core\condition\ConditionDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryDb;

class StaticBlockRepositoryDb extends AbstractEntityRepositoryDb implements StaticBlockRepositoryInterface
{

    protected $table = 'static_block';

    public function __construct(
        StaticBlockFactory $factory,
        ConditionDbParser $conditionParser,
        Connection $db
    ) {
        parent::__construct($factory, $conditionParser, $db);
    }
}
