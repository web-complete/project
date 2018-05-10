<?php

namespace cubes\system\user\repository;

use cubes\system\mongo\AbstractEntityRepositoryMongo;
use cubes\system\mongo\ConditionMongoDbParser;
use cubes\system\mongo\Mongo;
use cubes\system\user\UserFactory;

class UserRepositoryMongo extends AbstractEntityRepositoryMongo implements UserRepositoryInterface
{

    protected $collectionName = 'user';

    public function __construct(
        UserFactory $factory,
        Mongo $mongo,
        ConditionMongoDbParser $conditionParser
    ) {
        parent::__construct($factory, $mongo, $conditionParser);
    }
}
