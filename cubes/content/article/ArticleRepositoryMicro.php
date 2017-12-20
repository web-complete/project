<?php

namespace cubes\content\article;

use WebComplete\core\condition\ConditionMicroDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryMicro;
use WebComplete\microDb\MicroDb;

class ArticleRepositoryMicro extends AbstractEntityRepositoryMicro implements ArticleRepositoryInterface
{

    protected $collectionName = 'article';

    public function __construct(
        ArticleFactory $factory,
        MicroDb $microDb,
        ConditionMicroDbParser $conditionParser
    ) {
        parent::__construct($factory, $microDb, $conditionParser);
    }
}
