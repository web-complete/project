<?php

namespace WebComplete\admin\controllers;

class AppController extends AbstractAdminController
{

    protected $layout = '@admin/views/layouts/admin.php';

    /**
     * @throws \Exception
     */
    public function index()
    {
        return $this->html('@admin/views/App/index.php', ['name' => 'World']);
    }
}
