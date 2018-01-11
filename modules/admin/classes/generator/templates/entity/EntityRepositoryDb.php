<?php

use modules\admin\classes\generator\Config;

/** @var Config $config */

?>


namespace <?=$config->namespace ?>;

use Doctrine\DBAL\Connection;
use WebComplete\core\condition\ConditionDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryDb;

class <?=$config->nameCamel ?>RepositoryDb extends AbstractEntityRepositoryDb implements <?=$config->nameCamel ?>RepositoryInterface
{

    protected $table = '<?=$config->nameUnderscore ?>';

    /**
     * @param <?=$config->nameCamel ?>Factory $factory
     * @param ConditionDbParser $conditionParser
     * @param Connection $db
     */
    public function __construct(
        <?=$config->nameCamel ?>Factory $factory,
        ConditionDbParser $conditionParser,
        Connection $db
    ) {
        parent::__construct($factory, $conditionParser, $db);
    }
}
