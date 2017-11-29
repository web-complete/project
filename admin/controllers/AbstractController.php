<?php

namespace admin\controllers;

use cubes\system\auth\IdentityInterface;
use cubes\system\user\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\mvc\view\ViewInterface;

class AbstractController extends \WebComplete\mvc\controller\AbstractController
{

    protected $needAuth = true;
    protected $layout = '@admin/views/layouts/admin.php';

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
     * @return bool
     * @throws \Symfony\Component\Filesystem\Exception\IOException
     */
    public function beforeAction(): bool
    {
        return $this->authorizeUser() && parent::beforeAction();
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
