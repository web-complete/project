<?php

namespace cubes\multilang\translation\admin;

use cubes\multilang\translation\TranslationConfig;
use modules\admin\controllers\AbstractEntityController;

class Controller extends AbstractEntityController
{
    protected $entityConfigClass = TranslationConfig::class;
    protected $defaultSortField = 'namespace';
    protected $defaultSortDir = 'asc';
}
