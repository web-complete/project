<?php

namespace admin\controllers;

use admin\assets\AdminAsset;
use cubes\system\user\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\mvc\view\ViewInterface;

abstract class AbstractAdminController extends AbstractController
{

    /**
     * @var AdminAsset
     */
    private $adminAsset;

    /**
     * @param Request $request
     * @param Response $response
     * @param ViewInterface $view
     * @param UserService $userService
     * @param AdminAsset $adminAsset
     *
     * @throws \RuntimeException
     */
    public function __construct(
        Request $request,
        Response $response,
        ViewInterface $view,
        UserService $userService,
        AdminAsset $adminAsset
    ) {
        parent::__construct($request, $response, $view, $userService);
        $this->adminAsset = $adminAsset;
    }

    /**
     * @return bool
     * @throws \Symfony\Component\Filesystem\Exception\IOException
     */
    public function beforeAction(): bool
    {
        $this->view->getAssetManager()->registerAsset($this->adminAsset);
        return parent::beforeAction();
    }
}
