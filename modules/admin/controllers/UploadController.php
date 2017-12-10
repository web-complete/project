<?php

namespace modules\admin\controllers;

use cubes\system\file\FileService;
use cubes\system\settings\Settings;
use cubes\system\user\UserService;
use modules\admin\assets\AdminAsset;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\mvc\view\ViewInterface;

class UploadController extends AbstractController
{

    /**
     * @var FileService
     */
    private $fileService;

    /**
     * @param Request $request
     * @param Response $response
     * @param ViewInterface $view
     * @param Settings $settings
     * @param AdminAsset $adminAsset
     * @param UserService $userService
     * @param FileService $fileService
     */
    public function __construct(
        Request $request,
        Response $response,
        ViewInterface $view,
        Settings $settings,
        AdminAsset $adminAsset,
        UserService $userService,
        FileService $fileService
    ) {
        parent::__construct($request, $response, $view, $settings, $adminAsset, $userService);
        $this->fileService = $fileService;
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionUpload(): Response
    {
        $code = $this->request->get('code');
        $sort = (int)$this->request->get('sort', 100);
        $data = (array)$this->request->get('data', []);

        $uploadedFiles = $this->request->files->all();
        /** @var UploadedFile $uploadedFile */
        if ($uploadedFile = \reset($uploadedFiles)) {
            $file = $this->fileService->createFileFromPath(
                $uploadedFile->getPathname(),
                $uploadedFile->getClientOriginalName(),
                $uploadedFile->getMimeType(),
                $code,
                $sort,
                $data
            );
            if ($file->getId()) {
                return $this->responseJsonSuccess([
                    'id' => $file->getId(),
                    'name' => $file->file_name,
                    'url' => $file->url,
                ]);
            }
            return $this->responseJsonFail('File upload error');
        }

        return $this->responseJsonFail('No file uploaded');
    }
}
