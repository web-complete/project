<?php

namespace cubes\ecommerce\classifier\repository;

use cubes\ecommerce\classifier\ClassifierItemFactory;
use Doctrine\DBAL\Connection;
use WebComplete\core\condition\ConditionDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryDb;

class ClassifierItemRepositoryDb extends AbstractEntityRepositoryDb implements ClassifierItemRepositoryInterface
{

    protected $table = 'classifier';

    protected $serializeFields = ['multilang'];

    /**
     * @param ClassifierItemFactory $factory
     * @param ConditionDbParser $conditionParser
     * @param Connection $db
     */
    public function __construct(
        ClassifierItemFactory $factory,
        ConditionDbParser $conditionParser,
        Connection $db
    ) {
        parent::__construct($factory, $conditionParser, $db);
    }
}
