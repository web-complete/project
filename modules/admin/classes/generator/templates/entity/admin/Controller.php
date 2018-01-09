<?php

use modules\admin\classes\generator\Config;

/** @var Config $config */

?>


namespace <?=$config->namespace ?>\admin;

use <?=$config->namespace ?>\<?=$config->nameCamel ?>Config;
use modules\admin\controllers\AbstractEntityController;

class Controller extends AbstractEntityController
{
    protected $entityConfigClass = <?=$config->nameCamel ?>Config::class;
}
