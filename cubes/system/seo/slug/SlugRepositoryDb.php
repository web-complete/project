<?php

namespace cubes\system\seo\slug;

use Doctrine\DBAL\Connection;
use WebComplete\core\condition\ConditionDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryDb;

class SlugRepositoryDb extends AbstractEntityRepositoryDb implements SlugRepositoryInterface
{

    protected $table = 'slug';

    /**
     * @param SlugFactory $factory
     * @param ConditionDbParser $conditionParser
     * @param Connection $db
     */
    public function __construct(
        SlugFactory $factory,
        ConditionDbParser $conditionParser,
        Connection $db
    ) {
        parent::__construct($factory, $conditionParser, $db);
    }
}
