<?php

namespace modules\admin\classes;

use modules\admin\assets\AdminAsset;
use WebComplete\mvc\ApplicationConfig;
use WebComplete\mvc\assets\AbstractAsset;
use WebComplete\mvc\router\Routes;

class CubeHelper
{
    /**
     * @var AdminAsset
     */
    private $adminAsset;
    /**
     * @var ApplicationConfig
     */
    private $config;
    /**
     * @var PageRoutes
     */
    private $pageRoutes;
    /**
     * @var Navigation
     */
    private $navigation;

    /**
     * @param AdminAsset $adminAsset
     * @param ApplicationConfig $config
     * @param PageRoutes $pageRoutes
     * @param Navigation $navigation
     */
    public function __construct(
        AdminAsset $adminAsset,
        ApplicationConfig $config,
        PageRoutes $pageRoutes,
        Navigation $navigation
    ) {

        $this->adminAsset = $adminAsset;
        $this->config = $config;
        $this->pageRoutes = $pageRoutes;
        $this->navigation = $navigation;
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
     * @param array $routeDefinition ex: ['GET', '/admin/settings', [SettingsController::class, 'actionIndex']]
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
}