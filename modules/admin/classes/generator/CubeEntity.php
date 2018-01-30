<?php

namespace modules\admin\classes\generator;

use WebComplete\core\utils\container\ContainerInterface;
use WebComplete\mvc\view\View;

class CubeEntity
{

    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var Config
     */
    private $config;

    /**
     * @param ContainerInterface $container
     * @param Config $config
     */
    public function __construct(
        ContainerInterface $container,
        Config $config
    ) {
        $this->container = $container;
        $this->config = $config;
    }

    /**
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \WebComplete\core\utils\alias\AliasException
     */
    public function generate()
    {
        $nameCamel = $this->config->nameCamel;
        $this->createDir('admin');
        $this->createDir('migrations');
        $this->renderFile('Cube.php', 'Cube.php');
        $this->renderFile('Entity.php', $nameCamel . '.php');
        $this->renderFile('EntityConfig.php', $nameCamel . 'Config.php');
        $this->renderFile('EntityFactory.php', $nameCamel . 'Factory.php');
        $this->renderFile('EntityRepositoryDb.php', $nameCamel . 'RepositoryDb.php');
        $this->renderFile('EntityRepositoryMicro.php', $nameCamel . 'RepositoryMicro.php');
        $this->renderFile('EntityRepositoryInterface.php', $nameCamel . 'RepositoryInterface.php');
        $this->renderFile('EntityService.php', $nameCamel . 'Service.php');
        $this->renderFile('migrations/EntityMigration.php', 'migrations/' . $nameCamel . 'Migration.php');
        $this->renderFile('admin/Controller.php', 'admin/Controller.php');

        if ($this->config->customize) {
            $this->createDir('assets');
            $this->createDir('assets/AdminAsset');
            $this->createDir('assets/AdminAsset/js');
            $this->renderFile('assets/AdminAsset.php', 'assets/AdminAsset.php');
            $this->renderFile(
                'assets/js/VuePageEntityList.php',
                'assets/AdminAsset/js/VuePage' . $nameCamel . 'List.js',
                false
            );
            $this->renderFile(
                'assets/js/VuePageEntityDetail.php',
                'assets/AdminAsset/js/VuePage' . $nameCamel . 'Detail.js',
                false
            );
        }
    }

    /**
     * @param $name
     *
     * @throws \RuntimeException
     */
    protected function createDir($name)
    {
        if (!\mkdir($this->config->path . '/' . $name) && !\is_dir($this->config->path . '/' . $name)) {
            throw new \RuntimeException(\sprintf('Dir "%s" was not created', $this->config->path . '/' . $name));
        }
    }

    /**
     * @param $templateFile
     * @param $destFile
     * @param $isPhp
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \WebComplete\core\utils\alias\AliasException
     */
    protected function renderFile($templateFile, $destFile, bool $isPhp = true)
    {
        $view = $this->container->get(View::class);
        $content = $isPhp ? '<?php' : '';
        $content .= $view->render(__DIR__ . '/templates/entity/' . $templateFile, [
            'config' => $this->config
        ]);
        \file_put_contents($this->config->path . '/' . $destFile, $content);
    }
}
