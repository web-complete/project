<?php

namespace cubes\seo\redirect\admin;

use cubes\seo\redirect\RedirectConfig;
use modules\admin\controllers\AbstractEntityController;

class Controller extends AbstractEntityController
{
    protected $entityConfigClass = RedirectConfig::class;
}
