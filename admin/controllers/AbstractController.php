<?php

namespace admin\controllers;

use cubes\system\auth\IdentityInterface;
use cubes\system\user\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\mvc\assets\AbstractAsset;
use WebComplete\mvc\view\ViewInterface;
use admin\assets\AdminAsset;

class AbstractController extends \WebComplete\mvc\controller\AbstractController
{
    const URL_LOGIN = '/admin/login';

    protected $needAuth = true;
    protected $layout = '@admin/views/layouts/admin.php';
    protected $assets = [
        AdminAsset::class,
    ];

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @param Request $request
     * @param Response $response
     * @param ViewInterface $view
     * @param UserService $userService
     *
     * @throws \RuntimeException
     */
    public function __construct(
        Request $request,
        Response $response,
        ViewInterface $view,
        UserService $userService
    ) {
        parent::__construct($request, $response, $view);
        $this->userService = $userService;
        if ($session = $request->getSession()) {
            $session->start();
        }
    }

    /**
     * @return bool|string|Response
     * @throws \InvalidArgumentException
     * @throws \Symfony\Component\Filesystem\Exception\IOException
     */
    public function beforeAction()
    {
        if (!$this->authorizeUser()) {
            return $this->request->isXmlHttpRequest()
                ? false
                : $this->responseRedirect('/admin/login');
        }

        foreach ($this->assets as $assetClass) {
            $this->view->getAssetManager()->registerAsset(new $assetClass);
        }
        return parent::beforeAction();
    }

    /**
     * @return bool
     */
    protected function authorizeUser(): bool
    {
        /** @var IdentityInterface $user */
        if (($session = $this->request->getSession()) &&
            ($userId = $session->get('userId')) &&
            ($user = $this->userService->findById($userId))) {
            $this->userService->login($user);
        }

        return !$this->needAuth || (bool)$this->userService->current();
    }
}
