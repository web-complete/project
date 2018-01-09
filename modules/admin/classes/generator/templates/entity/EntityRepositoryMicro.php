<?php

use modules\admin\classes\generator\Config;

/** @var Config $config */

?>


namespace <?=$config->namespace ?>;

use WebComplete\core\condition\ConditionMicroDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryMicro;
use WebComplete\microDb\MicroDb;

class <?=$config->nameCamel ?>RepositoryMicro extends AbstractEntityRepositoryMicro implements <?=$config->nameCamel ?>RepositoryInterface
{

    protected $collectionName = '<?=$config->nameUnderscore ?>';

    /**
     * @param ProductPropertyFactory $factory
     * @param MicroDb $microDb
     * @param ConditionMicroDbParser $conditionParser
     */
    public function __construct(
        <?=$config->nameCamel ?>Factory $factory,
        MicroDb $microDb,
        ConditionMicroDbParser $conditionParser
    ) {
        parent::__construct($factory, $microDb, $conditionParser);
    }
}
