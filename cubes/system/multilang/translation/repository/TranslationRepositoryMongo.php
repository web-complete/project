<?php

namespace cubes\system\multilang\translation\repository;

use cubes\system\mongo\AbstractEntityRepositoryMongo;
use cubes\system\mongo\ConditionMongoDbParser;
use cubes\system\mongo\Mongo;
use cubes\system\multilang\lang\LangFactory;
use cubes\system\multilang\lang\repository\LangRepositoryInterface;

class TranslationRepositoryMongo extends AbstractEntityRepositoryMongo implements LangRepositoryInterface
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
