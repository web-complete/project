<?php

namespace cubes\system\file\admin;

use cubes\system\file\File;
use cubes\system\file\FileService;
use cubes\system\file\ImageHelper;
use modules\admin\controllers\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\core\condition\Condition;

class Controller extends AbstractController
{

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionUploadFile(): Response
    {
        $fileService = $this->container->get(FileService::class);
        $code = $this->request->get('code');
        $sort = (int)$this->request->get('sort', 100);
        $data = (array)$this->request->get('data', []);
        $cropData = (array)\json_decode($this->request->get('cropData'), true);

        $uploadedFiles = $this->request->files->all();
        /** @var UploadedFile $uploadedFile */
        if ($uploadedFile = \reset($uploadedFiles)) {
            $file = $fileService->createFileFromPath(
                $uploadedFile->getPathname(),
                $uploadedFile->getClientOriginalName(),
                $uploadedFile->getMimeType(),
                $code,
                $sort,
                $data
            );
            if ($file && $file->getId()) {
                if ($cropData && ($image = ImageHelper::getImage($file->getId()))) {
                    $image->crop($cropData);
                    $file = $image->getFile();
                }

                return $this->responseJsonSuccess([
                    'id' => $file->getId(),
                    'name' => $file->file_name,
                    'filelink' => $file->url,
                ]);
            }

            return $this->responseJsonFail('File upload error');
        }

        return $this->responseJsonFail('No file uploaded');
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionDeleteFile(): Response
    {
        $fileService = $this->container->get(FileService::class);
        if ($ids = (array)$this->request->get('id')) {
            $fileService->deleteAll(new Condition(['id' => $ids]));
        }

        return $this->responseJsonSuccess([]);
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionUpdateImage(): Response
    {
        $fileService = $this->container->get(FileService::class);
        $fileId = $this->request->get('id');
        $title = $this->request->get('title', '');
        $alt = $this->request->get('alt', '');
        if ($fileId && ($file = $fileService->findById($fileId))) {
            /** @var File $file */
            $data = $file->data;
            $data['title'] = $title;
            $data['alt'] = $alt;
            $file->data = $data;
            $fileService->save($file);

            return $this->responseJsonSuccess([]);
        }

        return $this->responseJsonFail('File not found');
    }
}
