<?php

namespace cubes\system\settings\controllers;

use admin\assets\AdminAsset;
use admin\controllers\AbstractController;
use cubes\system\settings\Settings;
use cubes\system\user\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\mvc\view\ViewInterface;

class SettingsController extends AbstractController
{

    /**
     * @var Settings
     */
    private $settings;

    public function __construct(
        Request $request,
        Response $response,
        ViewInterface $view,
        AdminAsset $adminAsset,
        UserService $userService,
        Settings $settings
    ) {
        parent::__construct($request, $response, $view, $adminAsset, $userService);
        $this->settings = $settings;
    }

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
                'settings' => $this->settings->getStructure()
            ]);
        }
        return $this->responseJsonFail('Data is empty');
    }
}
