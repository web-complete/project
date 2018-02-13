<?php

namespace cubes\seo\sitemap\admin;

use cubes\seo\sitemap\SeoSitemapProcessor;
use modules\admin\controllers\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\core\utils\alias\AliasService;

class Controller extends AbstractController
{
    protected $permission = 'admin:cubes:sitemap:edit';

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionGet(): Response
    {
        return $this->responseJsonSuccess($this->getInfo());
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionGenerate(): Response
    {
        $aliasService = $this->container->get(AliasService::class);
        $dir = $aliasService->get('@web');
        $file = $aliasService->get('@web/sitemap.xml');

        if (!\is_writable($dir)) {
            return $this->responseJsonFail($dir . ' is not writable');
        }
        if (\file_exists($file) && !\is_writable($file)) {
            return $this->responseJsonFail($file . ' is not writable');
        }

        $sitemapProcessor = $this->container->get(SeoSitemapProcessor::class);
        $sitemapProcessor->run();
        return $this->responseJsonSuccess($this->getInfo());
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionUpload(): Response
    {
        $aliasService = $this->container->get(AliasService::class);
        $dir = $aliasService->get('@web');
        $file = $aliasService->get('@web/sitemap.xml');

        if (!\is_writable($dir)) {
            return $this->responseJsonFail($dir . ' is not writable');
        }
        if (\file_exists($file) && !\is_writable($file)) {
            return $this->responseJsonFail($file . ' is not writable');
        }

        $uploadedFiles = $this->request->files->all();
        if (!$uploadedFiles) {
            return $this->responseJsonFail('Файл не загружен');
        }
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = \reset($uploadedFiles);
        if ($uploadedFile->getError()) {
            return $this->responseJsonFail('Ошибка загрузки: ' . $uploadedFile->getErrorMessage());
        }

        \move_uploaded_file($uploadedFile->getPathname(), $file);
        return $this->responseJsonSuccess($this->getInfo());
    }

    /**
     * @return array
     * @throws \WebComplete\core\utils\alias\AliasException
     */
    protected function getInfo(): array
    {
        $result = [
            'size' => 0,
            'time' => 0,
        ];
        $aliasService = $this->container->get(AliasService::class);
        $file = $aliasService->get('@web/sitemap.xml');
        if (\file_exists($file)) {
            $result['size'] = \filesize($file);
            $result['time'] = \date('d.m.Y H:i:s', \filemtime($file));
        }
        return $result;
    }
}
