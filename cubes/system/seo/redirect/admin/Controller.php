<?php

namespace cubes\system\seo\redirect\admin;

use cubes\system\seo\redirect\RedirectConfig;
use modules\admin\controllers\AbstractEntityController;

class Controller extends AbstractEntityController
{
    protected $entityConfigClass = RedirectConfig::class;
}
