<?php

namespace cubes\system\seo\meta\repository;

use cubes\system\mongo\AbstractEntityRepositoryMongo;
use cubes\system\mongo\ConditionMongoDbParser;
use cubes\system\mongo\Mongo;
use cubes\system\seo\meta\MetaFactory;

class MetaRepositoryMongo extends AbstractEntityRepositoryMongo implements MetaRepositoryInterface
{
    protected $collectionName = 'meta';

    public function __construct(
        MetaFactory $factory,
        Mongo $mongo,
        ConditionMongoDbParser $conditionParser
    ) {
        parent::__construct($factory, $mongo, $conditionParser);
    }
}
