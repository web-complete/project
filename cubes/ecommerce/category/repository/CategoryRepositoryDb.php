<?php

namespace cubes\ecommerce\category\repository;

use cubes\ecommerce\category\CategoryFactory;
use Doctrine\DBAL\Connection;
use WebComplete\core\condition\ConditionDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryDb;

class CategoryRepositoryDb extends AbstractEntityRepositoryDb implements CategoryRepositoryInterface
{

    protected $table = 'category';

    protected $serializeFields = ['multilang', 'properties', 'properties_enabled'];

    /**
     * @param CategoryFactory $factory
     * @param ConditionDbParser $conditionParser
     * @param Connection $db
     */
    public function __construct(
        CategoryFactory $factory,
        ConditionDbParser $conditionParser,
        Connection $db
    ) {
        parent::__construct($factory, $conditionParser, $db);
    }
}
