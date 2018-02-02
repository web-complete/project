<?php

namespace cubes\content\staticPage\admin;

use cubes\content\staticPage\StaticPageConfig;
use modules\admin\controllers\AbstractEntityController;

class Controller extends AbstractEntityController
{
    protected $entityConfigClass = StaticPageConfig::class;
}
