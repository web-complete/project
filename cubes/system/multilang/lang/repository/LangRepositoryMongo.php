<?php

namespace cubes\system\multilang\lang\repository;

use cubes\system\mongo\AbstractEntityRepositoryMongo;
use cubes\system\mongo\ConditionMongoDbParser;
use cubes\system\mongo\Mongo;
use cubes\system\multilang\lang\LangFactory;

class LangRepositoryMongo extends AbstractEntityRepositoryMongo implements LangRepositoryInterface
{

    protected $collectionName = 'lang';

    public function __construct(
        LangFactory $factory,
        Mongo $mongo,
        ConditionMongoDbParser $conditionParser
    ) {
        parent::__construct($factory, $mongo, $conditionParser);
    }
}
