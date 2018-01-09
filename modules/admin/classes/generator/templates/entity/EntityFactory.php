<?php

use modules\admin\classes\generator\Config;

/** @var Config $config */

?>


namespace <?=$config->namespace ?>;

use WebComplete\core\factory\EntityFactory;

class <?=$config->nameCamel ?>Factory extends EntityFactory
{
    protected $objectClass = <?=$config->nameCamel ?>::class;
}
