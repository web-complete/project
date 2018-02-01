<?php

namespace cubes\ecommerce\classifier\admin;

use modules\admin\controllers\AbstractController;

class Controller extends AbstractController
{

    public function actionTree()
    {
        return $this->responseJsonSuccess();
    }
}
