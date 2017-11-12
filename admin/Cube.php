<?php

namespace admin;

use admin\assets\AdminAsset;
use WebComplete\core\cube\AbstractCube;
use WebComplete\core\utils\container\ContainerInterface;
use WebComplete\mvc\assets\AssetManager;

class Cube extends AbstractCube
{

    /**
     * @param ContainerInterface $container
     */
    public function bootstrap(ContainerInterface $container)
    {
        $assetManager = $container->get(AssetManager::class);
        $asset = $container->get(AdminAsset::class);
        $assetManager->registerAsset($asset);
    }

    /**
     * @param $definitions
     *
     * @return void
     */
    public function registerDependencies(array &$definitions)
    {
    }
}
