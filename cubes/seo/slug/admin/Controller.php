<?php

namespace cubes\seo\slug\admin;

use cubes\seo\slug\SlugConfig;
use modules\admin\controllers\AbstractEntityController;

class Controller extends AbstractEntityController
{
    protected $entityConfigClass = SlugConfig::class;
}
