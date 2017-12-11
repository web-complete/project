<?php

namespace cubes\system\settings\controllers;

use cubes\system\file\File;
use cubes\system\file\FileService;
use cubes\system\settings\Settings;
use cubes\system\user\UserService;
use modules\admin\assets\AdminAsset;
use modules\admin\classes\fields\FieldAbstract;
use modules\admin\classes\fields\FieldImage;
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
        if (\is_array($structure['fields'])) {
            foreach ($structure['fields'] as &$items) {
                if (\is_array($items)) {
                    /** @var FieldAbstract[] $items */
                    foreach ($items as $name => $item) {
                        $item->processField();
                        $items[$name] = $item->get();
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

        $this->settings->load();
        if ($fields = (array)$this->request->get('fields')) {
            foreach ($fields as $sectionsData) {
                foreach ((array)$sectionsData as $item) {
                    $name = $item['name'] ?? null;
                    if ($name && ($field = $this->settings->getField($name))) {
                        $field->value($item['value'] ?? '');
                    }
                }
            }
            $this->settings->save();

            /** @var FieldImage $fieldThemeLogo */
            $fieldThemeLogo = $this->settings->getField('theme_logo');
            return $this->responseJsonSuccess([
                'settings' => $this->settings->getStructure(),
                'theme' => $this->view->render('@admin/views/layouts/theme.php'),
                'logo' => $fieldThemeLogo ? $fieldThemeLogo->getUrl() : '',
            ]);
        }
        return $this->responseJsonFail('Data is empty');
    }
}
