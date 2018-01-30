<?php

use modules\admin\classes\generator\Config;

/** @var Config $config */

?>


namespace <?=$config->namespace ?>;

use WebComplete\core\cube\AbstractCube;
use WebComplete\core\utils\container\ContainerInterface;
use <?=$config->namespace ?>\migrations\<?=$config->nameCamel ?>Migration;
use modules\admin\classes\CubeHelper;
<?php if ($config->customize) { ?>
use <?=$config->namespace ?>\assets\<?=$config->nameCamel ?>Asset;
<?php } ?>

class Cube extends AbstractCube
{
    /**
     * @param ContainerInterface $container
     *
     * @throws \RuntimeException
     */
    public function bootstrap(ContainerInterface $container)
    {
        $entityConfig = $container->get(<?=$config->nameCamel ?>Config::class);
        $cubeHelper = $container->get(CubeHelper::class);
        $cubeHelper->defaultCrud($entityConfig);
<?php if ($config->customize) { ?>

        $name = $entityConfig->name;
        $cubeHelper->appendAsset($container->get(<?=$config->nameCamel ?>Asset::class));
        $cubeHelper->addVueRoute(['path' => '/list/' . $name, 'component' => 'VuePage<?=$config->nameCamel ?>List']);
        $cubeHelper->addVueRoute(['path' => '/detail/' . $name . '/:id', 'component' => 'VuePage<?=$config->nameCamel ?>Detail']);
<?php } ?>
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
