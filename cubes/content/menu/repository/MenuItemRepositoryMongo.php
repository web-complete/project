<?php

namespace cubes\content\menu\repository;

use cubes\content\menu\MenuItemFactory;
use cubes\system\mongo\AbstractEntityRepositoryMongo;
use cubes\system\mongo\ConditionMongoDbParser;
use cubes\system\mongo\Mongo;

class MenuItemRepositoryMongo extends AbstractEntityRepositoryMongo implements MenuItemRepositoryInterface
{

    protected $collectionName = 'menu';

    public function __construct(
        MenuItemFactory $factory,
        Mongo $mongo,
        ConditionMongoDbParser $conditionParser
    ) {
        parent::__construct($factory, $mongo, $conditionParser);
    }
}
