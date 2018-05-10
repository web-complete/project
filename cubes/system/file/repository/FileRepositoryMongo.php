<?php

namespace cubes\system\file\repository;

use cubes\system\file\FileFactory;
use cubes\system\mongo\AbstractEntityRepositoryMongo;
use cubes\system\mongo\ConditionMongoDbParser;
use cubes\system\mongo\Mongo;

class FileRepositoryMongo extends AbstractEntityRepositoryMongo implements FileRepositoryInterface
{

    protected $collectionName = 'file';

    public function __construct(
        FileFactory $factory,
        Mongo $mongo,
        ConditionMongoDbParser $conditionParser
    ) {
        parent::__construct($factory, $mongo, $conditionParser);
    }
}
