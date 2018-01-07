<?php

namespace modules\pub\controllers;

class IndexController extends AbstractController
{

    /**
     * @throws \Exception
     */
    public function actionIndex()
    {
        return $this->responseHtml('@pub/views/index/index.php');
    }
}
