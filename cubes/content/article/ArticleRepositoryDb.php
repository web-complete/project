<?php

namespace cubes\content\article;

use Doctrine\DBAL\Connection;
use WebComplete\core\condition\ConditionDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryDb;

class ArticleRepositoryDb extends AbstractEntityRepositoryDb implements ArticleRepositoryInterface
{

    protected $table = 'article';

    public function __construct(
        ArticleFactory $factory,
        ConditionDbParser $conditionParser,
        Connection $db
    ) {
        parent::__construct($factory, $conditionParser, $db);
    }
}
