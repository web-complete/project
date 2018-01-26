<?php

namespace cubes\notification\template;

use WebComplete\core\condition\ConditionMicroDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryMicro;
use WebComplete\microDb\MicroDb;

class TemplateRepositoryMicro extends AbstractEntityRepositoryMicro implements TemplateRepositoryInterface
{

    protected $collectionName = 'notification_template';

    /**
     * @param TemplateFactory $factory
     * @param MicroDb $microDb
     * @param ConditionMicroDbParser $conditionParser
     */
    public function __construct(
        TemplateFactory $factory,
        MicroDb $microDb,
        ConditionMicroDbParser $conditionParser
    ) {
        parent::__construct($factory, $microDb, $conditionParser);
    }
}
