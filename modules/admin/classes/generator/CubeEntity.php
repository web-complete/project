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
        if (!\mkdir($this->config->path . '/admin') && !\is_dir($this->config->path . '/admin')) {
            throw new \RuntimeException(\sprintf('Dir "%s" was not created', $this->config->path . '/admin'));
        }
        if (!\mkdir($this->config->path . '/migrations') && !\is_dir($this->config->path . '/migrations')) {
            throw new \RuntimeException(\sprintf('Dir "%s" was not created', $this->config->path . '/migrations'));
        }
        $nameCamel = $this->config->nameCamel;
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
    }

    /**
     * @param $templateFile
     * @param $destFile
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \WebComplete\core\utils\alias\AliasException
     */
    protected function renderFile($templateFile, $destFile)
    {
        $view = $this->container->get(View::class);
        $content = '<?php' . $view->render(__DIR__ . '/templates/entity/' . $templateFile, [
            'config' => $this->config
        ]);
        \file_put_contents($this->config->path . '/' . $destFile, $content);
    }
}
