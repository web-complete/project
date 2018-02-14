<?php

namespace modules\admin\controllers;

use cubes\system\auth\IdentityInterface;
use cubes\system\settings\Settings;
use cubes\system\user\UserService;
use modules\admin\classes\csrf\CSRF;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\core\utils\container\ContainerInterface;
use WebComplete\mvc\exception\Exception;
use modules\admin\assets\AdminAsset;
use WebComplete\mvc\router\exception\NotAllowedException;

class AbstractController extends \WebComplete\mvc\controller\AbstractController
{
    const URL_LOGIN = '/admin/login';

    protected $needAuth = true;
    protected $layout = '@admin/views/layouts/admin.php';
    protected $permission;

    /**
     * @var UserService
     */
    protected $userService;
    /**
     * @var AdminAsset
     */
    protected $adminAsset;
    /**
     * @var Settings
     */
    public $settings;

    /**
     * @param ContainerInterface $container
     *
     * @throws \RuntimeException
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->settings = $this->container->get(Settings::class);
        $this->userService = $this->container->get(UserService::class);
        $this->adminAsset = $this->container->get(AdminAsset::class);
        if ($session = $this->request->getSession()) {
            $session->start();
        }
    }

    /**
     * @return bool|string|Response
     * @throws \InvalidArgumentException
     * @throws \Symfony\Component\Filesystem\Exception\IOException
     * @throws NotAllowedException
     */
    public function beforeAction()
    {
        $this->container->get(CSRF::class)->process();
        if (!$this->authorizeUser()) {
            return $this->request->isXmlHttpRequest()
                ? false
                : $this->responseRedirect('/admin/login');
        }

        $this->checkPermission($this->permission);
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
    protected function responseJsonSuccess(array $data = []): Response
    {
        if (isset($data['result'])) {
            throw new Exception('FieldFactory "result" is not allowed');
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
            throw new Exception('FieldFactory "result" is not allowed');
        }
        return parent::responseJson(\array_merge($data, ['result' => false, 'error' => $error]));
    }

    /**
     * @param string|null $permissionName
     * @param array $params
     *
     * @return bool
     * @throws NotAllowedException
     */
    protected function checkPermission(string $permissionName = null, array $params = []): bool
    {
        if ($permissionName) {
            if ((!$user = $this->userService->current()) || !$user->can($permissionName, $params)) {
                throw new NotAllowedException('Access denied');
            }
        }
        return true;
    }
}
