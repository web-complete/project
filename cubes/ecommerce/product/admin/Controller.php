<?php

namespace cubes\ecommerce\product\admin;

use cubes\ecommerce\product\ProductConfig;
use modules\admin\controllers\AbstractEntityController;

class Controller extends AbstractEntityController
{
    protected $entityConfigClass = ProductConfig::class;
}
