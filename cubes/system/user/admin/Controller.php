<?php

namespace cubes\system\user\admin;

use cubes\system\user\UserConfig;
use modules\admin\controllers\AbstractEntityController;

class Controller extends AbstractEntityController
{
    protected $entityConfigClass = UserConfig::class;
}
