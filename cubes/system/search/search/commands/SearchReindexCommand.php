<?php

namespace cubes\system\search\search\commands;

use cubes\system\search\search\SearchEntityIndexer;
use cubes\system\search\search\SearchService;
use modules\admin\classes\EntityConfig;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WebComplete\core\cube\CubeManager;
use WebComplete\core\entity\AbstractEntityService;
use WebComplete\core\utils\container\ContainerInterface;

class SearchReindexCommand extends Command
{
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var CubeManager
     */
    private $cubeManager;
    /**
     * @var SearchService
     */
    private $searchService;
    /**
     * @var SearchEntityIndexer
     */
    private $searchEntityIndexer;

    /**
     * @param ContainerInterface $container
     *
     * @throws \Symfony\Component\Console\Exception\LogicException
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
        $this->cubeManager = $container->get(CubeManager::class);
        $this->searchService = $container->get(SearchService::class);
        $this->searchEntityIndexer = $container->get(SearchEntityIndexer::class);
    }

    /**
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure()
    {
        $this->setName('search:reindex')->setDescription('Reindex search');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return null|int
     * @throws \ReflectionException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->searchService->clear();
        $cubes = $this->cubeManager->getCubes();
        foreach ($cubes as $cube) {
            $reflectionClass = new \ReflectionClass($cube);
            $namespace = $reflectionClass->getNamespaceName();
            $namespaceParts = \explode('\\', $namespace);
            $name = \ucfirst(\array_pop($namespaceParts));
            $entityConfigClass = $namespace . '\\' . $name . 'Config';
            if (\class_exists($entityConfigClass)) {
                /** @var EntityConfig $entityConfig */
                $entityConfig = $this->container->get($entityConfigClass);
                if ($entityConfig->searchable) {
                    echo $entityConfig->name . ': ';
                    /** @var AbstractEntityService $entityService */
                    $entityService = $this->container->get($entityConfig->entityServiceClass);
                    $items = $entityService->findAll();
                    foreach ($items as $item) {
                        $this->searchEntityIndexer->index($item);
                    }
                    echo \count($items) . " - Ok\n";
                }
            }
        }
        $output->writeln('Done!');
        return null;
    }
}
