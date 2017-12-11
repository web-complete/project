<?php

namespace modules\admin\controllers;

use cubes\system\file\File;
use cubes\system\file\FileService;
use cubes\system\settings\Settings;
use cubes\system\user\UserService;
use modules\admin\assets\AdminAsset;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\core\condition\Condition;
use WebComplete\mvc\view\ViewInterface;

class AjaxController extends AbstractController
{

    /**
     * @return Response
     */
    public function actionPing(): Response
    {
        return $this->responseJsonSuccess([]);
    }
}
