<?php

namespace modules\pub\controllers;

use cubes\system\settings\Settings;
use cubes\system\user\UserService;
use modules\pub\assets\BaseAsset;
use modules\pub\assets\PubAsset;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\core\utils\container\ContainerInterface;

class AbstractController extends \WebComplete\mvc\controller\AbstractController
{
    protected $layout = '@pub/views/layouts/public.php';

    /**
     * @var UserService
     */
    protected $userService;
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
        if ($session = $this->request->getSession()) {
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
        $this->view->getAssetManager()->registerAsset($this->container->get(BaseAsset::class));
        $this->view->getAssetManager()->registerAsset($this->container->get(PubAsset::class));
        return parent::beforeAction();
    }
}
