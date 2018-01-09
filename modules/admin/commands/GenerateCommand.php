<?php

namespace modules\admin\commands;

use modules\admin\classes\generator\Config;
use modules\admin\classes\generator\Generator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use WebComplete\core\utils\alias\AliasService;
use WebComplete\core\utils\container\ContainerInterface;
use WebComplete\core\utils\helpers\InflectorHelper;

/**
 * Class GenerateCommand
 * Usage example: php ./console.php admin:generate catalog product-property -t entity -f
 */
class GenerateCommand extends Command
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     *
     * @throws \Symfony\Component\Console\Exception\LogicException
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    /**
     */
    protected function configure()
    {
        $this->setName('admin:generate')
            ->setDescription('Code generator')
            ->addArgument('section', InputArgument::REQUIRED, "Cube's section (ex.: catalog)")
            ->addArgument('name', InputArgument::REQUIRED, "Cube's name in snake-case (ex.: product-property)")
            ->addOption('type', 't', InputOption::VALUE_REQUIRED, "Cube's type: empty (default), entity")
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Recreate if exists');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null
     * @throws \RuntimeException
     * @throws \WebComplete\core\utils\alias\AliasException
     * @throws \modules\admin\classes\generator\Exception
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $section = $input->getArgument('section');
        $name = $input->getArgument('name');
        $type = $input->getOption('type');
        $force = $input->getOption('force');
        if (!\in_array($type, Generator::$availableTypes, true)) {
            $type = Generator::DEFAULT_TYPE;
        }
        $config = new Config(
            $this->container->get(AliasService::class),
            $this->container->get(InflectorHelper::class),
            $section,
            $name,
            $type,
            $force
        );
        $generator = new Generator($this->container, $config);
        $path = $generator->run();
        $output->writeln('The cube was created: ' . $path);
        return null;
    }
}
