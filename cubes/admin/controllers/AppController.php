<?php

namespace cubes\admin\controllers;

class AppController extends AbstractAdminController
{

    protected $layout = '@admin/views/layouts/admin.php';

    /**
     * @throws \Exception
     */
    public function index()
    {
        return $this->responseHtml('@admin/views/App/index.php', ['name' => 'World']);
    }
}
