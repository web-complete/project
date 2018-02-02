<?php

namespace cubes\content\staticPage;

use WebComplete\core\condition\ConditionMicroDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryMicro;
use WebComplete\microDb\MicroDb;

class StaticPageRepositoryMicro extends AbstractEntityRepositoryMicro implements StaticPageRepositoryInterface
{

    protected $collectionName = 'static_page';

    /**
     * @param StaticPageFactory $factory
     * @param MicroDb $microDb
     * @param ConditionMicroDbParser $conditionParser
     */
    public function __construct(
        StaticPageFactory $factory,
        MicroDb $microDb,
        ConditionMicroDbParser $conditionParser
    ) {
        parent::__construct($factory, $microDb, $conditionParser);
    }
}
