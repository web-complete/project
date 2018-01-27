<?php

namespace modules\pub\controllers;

use cubes\seo\seo\SeoManager;
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
     * @var SeoManager
     */
    protected $seoManager;

    /**
     * @param ContainerInterface $container
     *
     * @throws \RuntimeException
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->userService = $this->container->get(UserService::class);
        $this->seoManager = $this->container->get(SeoManager::class);
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

    /**
     * @param string $title
     */
    protected function setTitle(string $title)
    {
        $meta = $this->seoManager->getCurrentPageMeta();
        if (!$meta->title) {
            $meta->title = $title;
        }
    }

    /**
     * @param string $description
     */
    protected function setDescription(string $description)
    {
        $meta = $this->seoManager->getCurrentPageMeta();
        if (!$meta->description) {
            $meta->description = $description;
        }
    }

    /**
     * @param string $keywords
     */
    protected function setKeywords(string $keywords)
    {
        $meta = $this->seoManager->getCurrentPageMeta();
        if (!$meta->keywords) {
            $meta->keywords = $keywords;
        }
    }
}
