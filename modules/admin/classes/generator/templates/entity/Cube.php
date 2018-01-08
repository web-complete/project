<?php

use modules\admin\classes\generator\Config;

/** @var Config $config */

?>


namespace <?=$config->namespace ?>;

use WebComplete\core\cube\AbstractCube;
use WebComplete\core\utils\container\ContainerInterface;
use <?=$config->namespace ?>\migrations\<?=$config->nameCamel ?>Migration;
use modules\admin\classes\CubeHelper;

class Cube extends AbstractCube
{
    /**
    * @param ContainerInterface $container
    */
    public function bootstrap(ContainerInterface $container)
    {
        $entityConfig = $container->get(<?=$config->nameCamel ?>Config::class);
        $cubeHelper = $container->get(CubeHelper::class);
        $cubeHelper->defaultCrud($entityConfig);
    }

    /**
    * @param $definitions
    *
    * @return void
    */
    public function registerDependencies(array &$definitions)
    {
        $definitions[<?=$config->nameCamel ?>RepositoryInterface::class] = \DI\object(<?=$config->nameCamel ?>RepositoryMicro::class);
    }

    /**
    * @return array
    */
    public function getMigrations(): array
    {
        return [
            '001_001' => <?=$config->nameCamel ?>Migration::class
        ];
    }
}
