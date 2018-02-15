<?php

namespace cubes\system\multilang\translation\admin;

use cubes\system\multilang\translation\TranslationConfig;
use modules\admin\controllers\AbstractEntityController;

class Controller extends AbstractEntityController
{
    protected $entityConfigClass = TranslationConfig::class;
    protected $defaultSortField = 'namespace';
    protected $defaultSortDir = 'asc';
}
