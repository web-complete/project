<?php

namespace cubes\system\user\controllers;

use cubes\system\user\UserConfig;
use modules\admin\controllers\AbstractEntityController;

class UserController extends AbstractEntityController
{
    protected $entityConfigClass = UserConfig::class;
}
