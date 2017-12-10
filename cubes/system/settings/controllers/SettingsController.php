<?php

namespace cubes\system\settings\controllers;

use admin\controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SettingsController extends AbstractController
{

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionGet(): Response
    {
        return $this->responseJsonSuccess([
            'settings' => $this->settings->getStructure()
        ]);
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionSave(): Response
    {
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
            ]);
        }
        return $this->responseJsonFail('Data is empty');
    }
}
