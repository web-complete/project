<?php

namespace cubes\notification\template\admin;

use cubes\notification\template\TemplateConfig;
use modules\admin\controllers\AbstractEntityController;

class Controller extends AbstractEntityController
{
    protected $entityConfigClass = TemplateConfig::class;
}
