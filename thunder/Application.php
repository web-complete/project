<?php

namespace WebComplete\thunder;

use DI\ContainerBuilder;
use DI\Scope;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\Cache\Simple\NullCache;
use Symfony\Component\HttpFoundation\Request;
use WebComplete\core\package\PackageManager;
use WebComplete\core\utils\alias\AliasHelper;
use WebComplete\core\utils\alias\AliasService;
use WebComplete\core\utils\container\ContainerAdapter;
use WebComplete\core\utils\container\ContainerInterface;
use WebComplete\core\utils\helpers\ClassHelper;
use WebComplete\thunder\ErrorHandler\ErrorHandler;
use WebComplete\thunder\router\Router;
use WebComplete\thunder\view\View;
use WebComplete\thunder\view\ViewInterface;

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
        $this->afterInit();
    }

    /**
     */
    protected function initErrorHandler()
    {
        $errorHandler = new ErrorHandler();
        $errorHandler->register();
        $errorHandler->setErrorPagePath($this->config['errorPagePath'] ?? '');
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function init(): array
    {
        $definitions = [
            AliasService::class => new AliasService($this->config['aliases'] ?? []),
            Router::class => new Router($this->config['routes'] ?? []),
            Request::class => Request::createFromGlobals(),
            ViewInterface::class => \DI\object(View::class)->scope(Scope::PROTOTYPE)
        ];

        $pmCache = \ENV === 'dev' ? new NullCache() : new FilesystemCache();
        $packageManager = new PackageManager(new ClassHelper(), $pmCache);
        $packageLocations = $this->config['packageLocations'] ?? [];
        foreach ($packageLocations as $location) {
            $packageManager->registerAll($location, $definitions);
        }

        return $definitions;
    }

    protected function afterInit()
    {
        AliasHelper::setInstance($this->container->get(AliasService::class));
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
