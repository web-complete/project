<?php

namespace cubes\system\seo\redirect\repository;

use cubes\system\mongo\AbstractEntityRepositoryMongo;
use cubes\system\mongo\ConditionMongoDbParser;
use cubes\system\mongo\Mongo;
use cubes\system\seo\redirect\RedirectFactory;

class RedirectRepositoryMongo extends AbstractEntityRepositoryMongo implements RedirectRepositoryInterface
{

    protected $collectionName = 'redirect';

    public function __construct(
        RedirectFactory $factory,
        Mongo $mongo,
        ConditionMongoDbParser $conditionParser
    ) {
        parent::__construct($factory, $mongo, $conditionParser);
    }
}
