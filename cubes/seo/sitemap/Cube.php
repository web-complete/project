<?php 

namespace cubes\seo\sitemap;

use cubes\seo\sitemap\admin\Controller;
use cubes\seo\sitemap\assets\AdminAsset;
use modules\admin\classes\CubeHelper;
use WebComplete\core\cube\AbstractCube;
use WebComplete\core\utils\container\ContainerInterface;

class Cube extends AbstractCube
{
    /**
     * @param ContainerInterface $container
     */
    public function bootstrap(ContainerInterface $container)
    {
        $cubeHelper = $container->get(CubeHelper::class);
        $cubeHelper->appendAsset($container->get(AdminAsset::class))
            ->addBackendRoute(['GET', '/admin/api/sitemap/get', [Controller::class, 'actionGet']])
            ->addBackendRoute(['POST', '/admin/api/sitemap/generate', [Controller::class, 'actionGenerate']])
            ->addBackendRoute(['POST', '/admin/api/sitemap/upload', [Controller::class, 'actionUpload']])
            ->addVueRoute(['path' => '/sitemap', 'component' => 'VuePageSitemap'])
            ->addMenuSection('SEO', 200)
            ->addMenuItem('SEO', 'Sitemap', '/sitemap', 150);
    }
}
