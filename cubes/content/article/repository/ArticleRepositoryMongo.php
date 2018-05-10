<?php

namespace cubes\content\article\repository;

use cubes\content\article\ArticleFactory;
use cubes\system\mongo\AbstractEntityRepositoryMongo;
use cubes\system\mongo\ConditionMongoDbParser;
use cubes\system\mongo\Mongo;

class ArticleRepositoryMongo extends AbstractEntityRepositoryMongo implements ArticleRepositoryInterface
{

    protected $collectionName = 'article';

    public function __construct(
        ArticleFactory $factory,
        Mongo $mongo,
        ConditionMongoDbParser $conditionParser
    ) {
        parent::__construct($factory, $mongo, $conditionParser);
    }
}
