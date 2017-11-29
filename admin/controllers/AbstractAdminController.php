<?php

namespace admin\controllers;

use admin\assets\AdminAsset;
use cubes\system\user\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\mvc\controller\AbstractController;
use WebComplete\mvc\view\ViewInterface;

abstract class AbstractAdminController extends AbstractController
{
    /**
     * @var AdminAsset
     */
    private $adminAsset;
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @param Request $request
     * @param Response $response
     * @param ViewInterface $view
     * @param AdminAsset $adminAsset
     * @param UserService $userService
     */
    public function __construct(
        Request $request,
        Response $response,
        ViewInterface $view,
        AdminAsset $adminAsset,
        UserService $userService
    ) {
        parent::__construct($request, $response, $view);
        $this->adminAsset = $adminAsset;
        $this->userService = $userService;
    }

    public function beforeAction(): bool
    {
        $this->view->getAssetManager()->registerAsset($this->adminAsset);
        return parent::beforeAction();
    }
}
