<?php

namespace cubes\content\article\repository;

use cubes\content\article\ArticleFactory;
use Doctrine\DBAL\Connection;
use WebComplete\core\condition\ConditionDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryDb;

class ArticleRepositoryDb extends AbstractEntityRepositoryDb implements ArticleRepositoryInterface
{

    protected $table = 'article';
    protected $serializeFields = ['multilang'];

    public function __construct(
        ArticleFactory $factory,
        ConditionDbParser $conditionParser,
        Connection $db
    ) {
        parent::__construct($factory, $conditionParser, $db);
    }
}
