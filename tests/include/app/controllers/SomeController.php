<?php

namespace tests\app\controllers;

use WebComplete\mvc\controller\AbstractController;

class SomeController extends AbstractController
{

    public $controllerVar = 'a';

    protected $layout = '@app/views/layouts/main.php';

    public function actionString()
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

    public function actionArray()
    {
        return ['a' => 'b'];
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

    public function actionVars()
    {
        $this->layout = '@app/views/layouts/custom.php';
        return $this->responseHtml('@app/views/Some/vars.php', ['actionVar' => 'b']);
    }
}