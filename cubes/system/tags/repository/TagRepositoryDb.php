<?php

namespace cubes\system\tags\repository;

use cubes\system\tags\TagFactory;
use Doctrine\DBAL\Connection;
use WebComplete\core\condition\ConditionDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryDb;

class TagRepositoryDb extends AbstractEntityRepositoryDb implements TagRepositoryInterface
{

    protected $table = 'tag';
    protected $serializeFields = ['ids'];

    public function __construct(
        TagFactory $factory,
        ConditionDbParser $conditionParser,
        Connection $db
    ) {
        parent::__construct($factory, $conditionParser, $db);
    }
}
