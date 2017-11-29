<?php

namespace admin\controllers;

class IndexController extends AbstractAdminController
{

    /**
     * @throws \Exception
     */
    public function actionIndex()
    {
        return $this->responseHtml('@admin/views/App/index.php');
    }
}
