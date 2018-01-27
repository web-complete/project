<?php

namespace cubes\seo\meta\admin;

use cubes\seo\meta\MetaConfig;
use modules\admin\controllers\AbstractEntityController;

class Controller extends AbstractEntityController
{
    protected $entityConfigClass = MetaConfig::class;
}
