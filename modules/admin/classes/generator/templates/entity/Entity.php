<?php

use modules\admin\classes\generator\Config;

/** @var Config $config */

?>


namespace <?=$config->namespace ?>;

use WebComplete\core\entity\AbstractEntity;

/**
*
* @property $name
*/
class <?=$config->nameCamel ?> extends AbstractEntity
{

    /**
     * @return array
     */
    public static function fields(): array
    {
        return <?=$config->nameCamel ?>Config::getFieldTypes();
    }
}
