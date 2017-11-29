<?php

namespace admin;

use admin\assets\AdminAsset;
use WebComplete\core\cube\AbstractCube;
use WebComplete\core\utils\container\ContainerInterface;
use WebComplete\mvc\assets\AssetManager;

class Cube extends AbstractCube
{

    /**
     * @param $definitions
     *
     * @return void
     */
    public function registerDependencies(array &$definitions)
    {
    }
}
