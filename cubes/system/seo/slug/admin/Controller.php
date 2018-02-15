<?php

namespace cubes\system\seo\slug\admin;

use cubes\system\seo\slug\SlugConfig;
use modules\admin\controllers\AbstractEntityController;

class Controller extends AbstractEntityController
{
    protected $entityConfigClass = SlugConfig::class;
}
