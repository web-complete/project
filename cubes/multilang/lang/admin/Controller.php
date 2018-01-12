<?php

namespace cubes\multilang\lang\admin;

use cubes\multilang\lang\LangConfig;
use modules\admin\controllers\AbstractEntityController;

class Controller extends AbstractEntityController
{
    protected $entityConfigClass = LangConfig::class;
    protected $defaultSortField = 'sort';
    protected $defaultSortDir = 'asc';
}
