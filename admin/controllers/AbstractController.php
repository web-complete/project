<?php

namespace admin\controllers;

use cubes\system\auth\IdentityInterface;
use cubes\system\user\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\mvc\exception\Exception;
use WebComplete\mvc\view\ViewInterface;
use admin\assets\AdminAsset;

class AbstractController extends \WebComplete\mvc\controller\AbstractController
{
    const URL_LOGIN = '/admin/login';

    protected $needAuth = true;
    protected $layout = '@admin/views/layouts/admin.php';

    /**
     * @var UserService
     */
    protected $userService;
    /**
     * @var AdminAsset
     */
    protected $adminAsset;

    /**
     * @param Request $request
     * @param Response $response
     * @param ViewInterface $view
     * @param AdminAsset $adminAsset
     * @param UserService $userService
     *
     */
    public function __construct(
        Request $request,
        Response $response,
        ViewInterface $view,
        AdminAsset $adminAsset,
        UserService $userService
    ) {
        parent::__construct($request, $response, $view);
        $this->userService = $userService;
        $this->adminAsset = $adminAsset;
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

        $this->view->getAssetManager()->registerAsset($this->adminAsset);
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

    /**
     * @param array $data
     *
     * @return Response
     * @throws \Exception
     */
    protected function responseJsonSuccess(array $data): Response
    {
        if (isset($data['result'])) {
            throw new Exception('Field "result" is not allowed');
        }
        return parent::responseJson(\array_merge($data, ['result' => true]));
    }

    /**
     * @param string $error
     * @param array $data
     *
     * @return Response
     * @throws \Exception
     */
    protected function responseJsonFail(string $error, array $data = []): Response
    {
        if (isset($data['result'])) {
            throw new Exception('Field "result" is not allowed');
        }
        return parent::responseJson(\array_merge($data, ['result' => false, 'error' => $error]));
    }
}
