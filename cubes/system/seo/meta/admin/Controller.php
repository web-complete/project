<?php

namespace cubes\system\seo\meta\admin;

use cubes\system\seo\meta\MetaConfig;
use modules\admin\controllers\AbstractEntityController;

class Controller extends AbstractEntityController
{
    protected $entityConfigClass = MetaConfig::class;
}
