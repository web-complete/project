<?php

use modules\admin\classes\generator\Config;

/** @var Config $config */

?>


namespace <?=$config->namespace ?>;

use WebComplete\core\entity\EntityRepositoryInterface;

interface <?=$config->nameCamel ?>RepositoryInterface extends EntityRepositoryInterface
{

}
