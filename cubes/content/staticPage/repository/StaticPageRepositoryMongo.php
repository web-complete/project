<?php

namespace cubes\content\staticPage\repository;

use cubes\content\staticPage\StaticPageFactory;
use cubes\system\mongo\AbstractEntityRepositoryMongo;
use cubes\system\mongo\ConditionMongoDbParser;
use cubes\system\mongo\Mongo;

class StaticPageRepositoryMongo extends AbstractEntityRepositoryMongo implements StaticPageRepositoryInterface
{

    protected $collectionName = 'static_page';

    public function __construct(
        StaticPageFactory $factory,
        Mongo $mongo,
        ConditionMongoDbParser $conditionParser
    ) {
        parent::__construct($factory, $mongo, $conditionParser);
    }
}
