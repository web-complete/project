<?php

namespace cubes\notification\template\repository;

use cubes\notification\template\TemplateFactory;
use cubes\system\mongo\AbstractEntityRepositoryMongo;
use cubes\system\mongo\ConditionMongoDbParser;
use cubes\system\mongo\Mongo;

class TemplateRepositoryMongo extends AbstractEntityRepositoryMongo implements TemplateRepositoryInterface
{

    protected $collectionName = 'notification_template';

    public function __construct(
        TemplateFactory $factory,
        Mongo $mongo,
        ConditionMongoDbParser $conditionParser
    ) {
        parent::__construct($factory, $mongo, $conditionParser);
    }
}
