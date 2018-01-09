<?php

namespace modules\admin\classes\generator;

use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use WebComplete\core\utils\container\ContainerInterface;

class Generator
{
    const DEFAULT_TYPE = 'empty';

    public static $availableTypes = ['empty', 'entity'];

    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var Config
     */
    private $config;
    /**
     * @var string
     */

    /**
     * @param ContainerInterface $container
     * @param Config $config
     */
    public function __construct(ContainerInterface $container, Config $config)
    {
        $this->container = $container;
        $this->filesystem = $container->get(Filesystem::class);
        $this->config = $config;
    }

    /**
     * @return string
     * @throws Exception
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \WebComplete\core\utils\alias\AliasException
     */
    public function run(): string
    {
        $this->createCubeDirectory();
        switch ($this->config->type) {
            case 'empty':
                $cubeGenerator = new CubeEmpty($this->container, $this->config);
                $cubeGenerator->generate();
                break;
            case 'entity':
                $cubeGenerator = new CubeEntity($this->container, $this->config);
                $cubeGenerator->generate();
                break;
        }
        return $this->config->path;
    }

    /**
     * @throws Exception
     */
    protected function createCubeDirectory()
    {
        if ($this->filesystem->exists($this->config->path)) {
            if ($this->config->force) {
                try {
                    $this->filesystem->remove($this->config->path);
                } catch (IOException $e) {
                    throw new Exception('Cannot remove directory: ' . $this->config->path, 0, $e);
                }
            } else {
                throw new Exception('Directory already exists:' . $this->config->path);
            }
        }
        try {
            $this->filesystem->mkdir($this->config->path);
        } catch (IOException $e) {
            throw new Exception('Cannot create directory: ' . $this->config->path, 0, $e);
        }
    }
}
