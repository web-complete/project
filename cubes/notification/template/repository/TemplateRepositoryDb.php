<?php

namespace cubes\notification\template\repository;

use cubes\notification\template\TemplateFactory;
use Doctrine\DBAL\Connection;
use WebComplete\core\condition\ConditionDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryDb;

class TemplateRepositoryDb extends AbstractEntityRepositoryDb implements TemplateRepositoryInterface
{

    protected $table = 'notification_template';

    /**
     * @param TemplateFactory $factory
     * @param ConditionDbParser $conditionParser
     * @param Connection $db
     */
    public function __construct(
        TemplateFactory $factory,
        ConditionDbParser $conditionParser,
        Connection $db
    ) {
        parent::__construct($factory, $conditionParser, $db);
    }
}
