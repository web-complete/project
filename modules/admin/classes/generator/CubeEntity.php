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
        $this->generateCubeClass();
    }

    /**
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \WebComplete\core\utils\alias\AliasException
     */
    protected function generateCubeClass()
    {
        $view = $this->container->get(View::class);
        $content = '<?php ' . $view->render(__DIR__ . '/templates/entity/Cube.php', [
                'config' => $this->config,
            ]);
        \file_put_contents($this->config->path . '/Cube.php', $content);
    }
}
