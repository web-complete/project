<?php

namespace cubes\content\staticBlock\admin;

use cubes\content\staticBlock\StaticBlockConfig;
use modules\admin\controllers\AbstractEntityController;

class Controller extends AbstractEntityController
{
    protected $entityConfigClass = StaticBlockConfig::class;
}
