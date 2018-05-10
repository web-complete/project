<?php

namespace cubes\content\menu\repository;

use cubes\content\menu\MenuItemFactory;
use WebComplete\core\condition\ConditionMicroDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryMicro;
use WebComplete\microDb\MicroDb;

class MenuItemRepositoryMicro extends AbstractEntityRepositoryMicro implements MenuItemRepositoryInterface
{

    protected $collectionName = 'menu';

    public function __construct(
        MenuItemFactory $factory,
        MicroDb $microDb,
        ConditionMicroDbParser $conditionParser
    ) {
        parent::__construct($factory, $microDb, $conditionParser);
    }
}
