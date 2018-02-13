<?php

namespace cubes\system\settings\admin;

use cubes\system\file\FileService;
use modules\admin\classes\fields\FieldAbstract;
use modules\admin\classes\fields\FieldImage;
use modules\admin\controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends AbstractController
{

    protected $permission = 'admin:cubes:settings';

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
        $fileService = $this->container->get(FileService::class);
        if ($deleteFileIds = (array)$this->request->get('deleteFileIds')) {
            foreach ($deleteFileIds as $deleteFileId) {
                @$fileService->delete($deleteFileId);
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
