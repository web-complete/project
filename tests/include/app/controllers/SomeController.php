<?php

namespace tests\app\controllers;

use WebComplete\thunder\controller\AbstractController;

class SomeController extends AbstractController
{

    protected $layout = '@app/views/layouts/main.php';

    public function actionIndex()
    {
        return 'index string';
    }

    public function actionLayout()
    {
        return $this->responseHtml('@app/views/Some/layout.php');
    }

    public function actionPartial()
    {
        return $this->responseHtmlPartial('@app/views/Some/partial.php');
    }

    public function actionJson()
    {
        return $this->responseJson(['a' => 'b']);
    }

    public function actionRedirect()
    {
        return $this->responseRedirect('url2', 301);
    }

    public function actionNotFound()
    {
        return $this->responseNotFound();
    }

    public function actionAccessDenied()
    {
        return $this->responseAccessDenied();
    }

    public function actionSystemError()
    {
        throw new \RuntimeException('some');
    }

    public function actionOnlyPost()
    {
        return 'only post';
    }
}