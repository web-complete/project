<?php

namespace modules\admin\classes\cube;

use cubes\search\search\Searchable;
use cubes\search\search\SearchObserver;
use cubes\seo\seo\SeoEntityObserver;
use cubes\system\tags\TagObserver;
use modules\admin\assets\AdminAsset;
use modules\admin\classes\EntityConfig;
use modules\admin\classes\Navigation;
use modules\admin\classes\VueRoutes;
use WebComplete\core\entity\AbstractEntityService;
use WebComplete\core\utils\container\ContainerInterface;
use WebComplete\mvc\ApplicationConfig;
use WebComplete\mvc\assets\AbstractAsset;
use WebComplete\mvc\router\Routes;

class CubeHelper
{
    /**
     * @var ContainerInterface
     */
    protected $container;
    /**
     * @var AdminAsset
     */
    protected $adminAsset;
    /**
     * @var ApplicationConfig
     */
    protected $config;
    /**
     * @var VueRoutes
     */
    protected $pageRoutes;
    /**
     * @var Navigation
     */
    protected $navigation;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->adminAsset = $this->container->get(AdminAsset::class);
        $this->config = $this->container->get(ApplicationConfig::class);
        $this->pageRoutes = $this->container->get(VueRoutes::class);
        $this->navigation = $this->container->get(Navigation::class);
    }

    /**
     * @param AbstractAsset $asset
     *
     * @return $this
     */
    public function appendAsset(AbstractAsset $asset)
    {
        $this->adminAsset->addAssetAfter($asset);
        return $this;
    }

    /**
     * @param AbstractAsset $asset
     *
     * @return $this
     */
    public function prependAsset(AbstractAsset $asset)
    {
        $this->adminAsset->addAssetBefore($asset);
        return $this;
    }

    /**
     * @param array $routeDefinition ex: ['GET', '/admin/settings', [Controller::class, 'actionIndex']]
     * @param string|null $beforeRoute
     *
     * @return $this
     */
    public function addBackendRoute(array $routeDefinition, string $beforeRoute = null)
    {
        /** @var Routes $routes */
        $routes = $this->config['routes'];
        $routes->addRoute($routeDefinition, $beforeRoute);
        $this->config['routes'] = $routes;
        return $this;
    }

    /**
     * @param array $routeDefinition ex: ['path' => '/settings', 'component' => 'VuePageSettings']
     * @param int $position
     *
     * @return $this
     */
    public function addVueRoute(array $routeDefinition, int $position = 100)
    {
        $this->pageRoutes->addRoute($position, $routeDefinition);
        return $this;
    }

    /**
     * @param string $name
     * @param int $sort
     *
     * @return $this
     */
    public function addMenuSection(string $name, int $sort)
    {
        $this->navigation->addSection($name, $sort);
        return $this;
    }

    /**
     * @param string $sectionName
     * @param string $name
     * @param string $frontUrl
     * @param int $sort
     *
     * @return $this
     */
    public function addMenuItem(string $sectionName, string $name, string $frontUrl, int $sort)
    {
        $this->navigation->addItem($sectionName, $name, $frontUrl, $sort);
        return $this;
    }

    /**
     * @param EntityConfig $entityConfig
     *
     * @return $this
     */
    public function observeEntityTagField(EntityConfig $entityConfig)
    {
        if ($entityConfig->tagField) {
            $entityService = $this->container->get($entityConfig->entityServiceClass);
            $tagObserver = $this->container->get(TagObserver::class);
            $tagObserver->listen($entityService, $entityConfig->tagField);
        }
        return $this;
    }

    /**
     * @param EntityConfig $entityConfig
     *
     * @return $this
     * @throws \RuntimeException
     */
    public function observeEntitySearch(EntityConfig $entityConfig)
    {
        if ($entityConfig->searchable) {
            /** @var AbstractEntityService $entityService */
            $entityService = $this->container->get($entityConfig->entityServiceClass);
            $entity = $entityService->create();
            if (!$entity instanceof Searchable) {
                throw new \RuntimeException(\get_class($entity) . ' must implement interface: ' . Searchable::class);
            }
            $searchObserver = $this->container->get(SearchObserver::class);
            $searchObserver->listen($entityService);
        }
        return $this;
    }

    /**
     * @param EntityConfig $entityConfig
     *
     * @return $this
     */
    public function observeEntitySeo(EntityConfig $entityConfig)
    {
        if ($entityConfig->entitySeoClass) {
            $entityService = $this->container->get($entityConfig->entityServiceClass);
            $entitySeo = $this->container->get($entityConfig->entitySeoClass);
            $seoObserver = $this->container->get(SeoEntityObserver::class);
            $seoObserver->listen($entityService, $entitySeo);
        }
        return $this;
    }

    /**
     * @param EntityConfig $entityConfig
     *
     * @return $this
     * @throws \RuntimeException
     */
    public function defaultCrud(EntityConfig $entityConfig)
    {
        $name = $entityConfig->name;
        $titleList = $entityConfig->titleList;
        $controllerClass = $entityConfig->controllerClass;
        $menuSectionName = $entityConfig->menuSectionName;
        $menuItemSort = $entityConfig->menuItemSort;
        $menuSectionSort = $entityConfig->menuSectionSort;

        $this
            ->addBackendRoute(['GET', "/admin/api/entity/$name", [$controllerClass, 'actionList']])
            ->addBackendRoute(['GET', "/admin/api/entity/$name/{id:\d+}", [$controllerClass, 'actionDetail']])
            ->addBackendRoute(['POST', "/admin/api/entity/$name/{id:\d+}", [$controllerClass, 'actionSave']])
            ->addBackendRoute(['DELETE', "/admin/api/entity/$name/{id:\d+}", [$controllerClass, 'actionDelete']])
            ->observeEntityTagField($entityConfig)
            ->observeEntitySearch($entityConfig)
            ->observeEntitySeo($entityConfig);

        if ($entityConfig->menuEnabled) {
            $this
                ->addMenuSection($menuSectionName, $menuSectionSort)
                ->addMenuItem($menuSectionName, $titleList, "/list/$name", $menuItemSort);
        }

        return $this;
    }
}
