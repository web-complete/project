<?php

namespace cubes\system\settings\controllers;

use cubes\system\file\File;
use cubes\system\file\FileService;
use cubes\system\settings\Settings;
use cubes\system\user\UserService;
use modules\admin\assets\AdminAsset;
use modules\admin\classes\FieldType;
use modules\admin\controllers\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\mvc\view\ViewInterface;

class SettingsController extends AbstractController
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
    public function actionGet(): Response
    {
        $structure = $this->settings->getStructure();
        if (\is_array($structure['data'])) {
            foreach ($structure['data'] as &$items) {
                if (\is_array($items)) {
                    /** @var array $items */
                    foreach ($items as &$item) {
                        if ($item['field'] === FieldType::FILE) {
                            $this->processFieldFile($item);
                        }
                        if ($item['field'] === FieldType::IMAGE) {
                            $this->processFieldFile($item);
                        }
                    }
                }
                unset($item);
            }
            unset($items);
        }

        return $this->responseJsonSuccess([
            'settings' => $structure,
        ]);
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionSave(): Response
    {
        if ($deleteFileIds = (array)$this->request->get('deleteFileIds')) {
            foreach ($deleteFileIds as $deleteFileId) {
                @$this->fileService->delete($deleteFileId);
            }
        }
        if ($data = (array)$this->request->get('data')) {
            $plainData = [];
            foreach ($data as $sectionsData) {
                foreach ((array)$sectionsData as $item) {
                    if ($code = $item['code'] ?? null) {
                        unset($item['code']);
                        $plainData[$code] = $item;
                    }
                }
            }
            $this->settings->setData($plainData);
            return $this->responseJsonSuccess([
                'settings' => $this->settings->getStructure(),
                'theme' => $this->view->render('@admin/views/layouts/theme.php'),
                'logo' => $this->getThemeLogo($plainData),
            ]);
        }
        return $this->responseJsonFail('Data is empty');
    }

    /**
     * @param array $item
     */
    protected function processFieldFile(array &$item)
    {
        if ($fileId = $item['value'] ?? null) {
            $fileIds = (array)$fileId;
            foreach ($fileIds as $fileId) {
                /** @var File $file */
                if ($file = $this->fileService->findById($fileId)) {
                    if (!isset($item['fieldParams']) || !\is_array($item['fieldParams'])) {
                        $item['fieldParams'] = [];
                    }
                    if (!isset($item['fieldParams']['data'])) {
                        $item['fieldParams']['data'] = [];
                    }
                    $item['fieldParams']['data'][$fileId] = \array_merge((array)$file->data, [
                        'name' => $file->file_name,
                        'url' => $file->url,
                    ]);
                }
            }
        }
    }

    /**
     * @param $plainData
     *
     * @return string
     */
    protected function getThemeLogo($plainData): string
    {
        if ($fileId = $plainData['theme_logo'] ?? null) {
            /** @var File $file */
            if ($file = $this->fileService->findById($fileId)) {
                return $file->url;
            }
        }
        return '';
    }
}
