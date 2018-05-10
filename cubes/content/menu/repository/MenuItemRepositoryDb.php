<?php

namespace cubes\content\menu\repository;

use cubes\content\menu\MenuItemFactory;
use Doctrine\DBAL\Connection;
use WebComplete\core\condition\ConditionDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryDb;

class MenuItemRepositoryDb extends AbstractEntityRepositoryDb implements MenuItemRepositoryInterface
{

    protected $table = 'menu';
    protected $serializeFields = ['multilang'];

    public function __construct(
        MenuItemFactory $factory,
        ConditionDbParser $conditionParser,
        Connection $db
    ) {
        parent::__construct($factory, $conditionParser, $db);
    }
}
