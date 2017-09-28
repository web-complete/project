<?php

namespace WebComplete\thunder;

use DI\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use WebComplete\core\package\PackageManager;
use WebComplete\core\utils\container\ContainerAdapter;
use WebComplete\core\utils\container\ContainerInterface;
use WebComplete\core\utils\helpers\ClassHelper;
use WebComplete\thunder\ErrorHandler\ErrorHandler;
use WebComplete\thunder\router\Router;

class Application
{
    /** @var array */
    protected $config;

    /** @var ContainerInterface */
    protected $container;

    /**
     * @param array $config
     *
     * @throws \Exception
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->initErrorHandler();
        $definitions = \array_merge(
            $this->init(),
            $this->config['definitions'] ?? []
        );
        $this->initContainer($definitions);
    }

    /**
     */
    protected function initErrorHandler()
    {
        ErrorHandler::init();
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function init(): array
    {
        $definitions = [
            Router::class => new Router($this->config['routes'] ?? []),
            Request::class => Request::createFromGlobals(),
        ];

        $pm = new PackageManager(new ClassHelper());
        $packageLocations = $this->config['packageLocations'] ?? [];
        foreach ($packageLocations as $location) {
            $pm->registerAll($location, $definitions);
        }

        return $definitions;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param $definitions
     *
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \InvalidArgumentException
     */
    protected function initContainer($definitions)
    {
        $definitions[ContainerInterface::class] = \DI\object(ContainerAdapter::class);
        $container = (new ContainerBuilder())->addDefinitions($definitions)->build();
        $this->container = $container->get(ContainerInterface::class);
        $this->container->setContainer($container);
    }
}
