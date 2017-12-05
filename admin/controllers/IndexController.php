<?php

namespace admin\controllers;

class IndexController extends AbstractController
{

    /**
     * @throws \Exception
     */
    public function actionIndex()
    {
        return $this->responseHtml('@admin/views/index/index.php');
    }
}
