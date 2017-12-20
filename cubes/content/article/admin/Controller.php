<?php

namespace cubes\content\article\admin;

use cubes\content\article\ArticleConfig;
use modules\admin\controllers\AbstractEntityController;

class Controller extends AbstractEntityController
{
    protected $entityConfigClass = ArticleConfig::class;
}
