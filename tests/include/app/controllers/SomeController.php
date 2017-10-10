<?php

namespace tests\app\controllers;

use WebComplete\thunder\controller\AbstractController;

class SomeController extends AbstractController
{

    public function actionIndex()
    {
        return 'index string';
    }
}