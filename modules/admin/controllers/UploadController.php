<?php

namespace modules\admin\controllers;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadController extends AbstractController
{

    public function actionUpload()
    {
        $files = $this->request->files->all();
        /** @var UploadedFile $file */
        if ($file = \reset($files)) {

        }
    }
}