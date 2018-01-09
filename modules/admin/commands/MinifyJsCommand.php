<?php

namespace modules\admin\commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use WebComplete\core\utils\container\ContainerInterface;
use WebComplete\mvc\assets\AbstractAsset;
use WebComplete\mvc\assets\AssetManager;

class MinifyJsCommand extends Command
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    protected function configure()
    {
        $this->setName('minify:js')
            ->setDescription('Minify js in assets')
            ->addArgument('assets', InputArgument::IS_ARRAY, 'The list of asset classes')
            ->setHelp("This command allows you to minify js using babel minification.\n" .
            "System requirements:\n" .
            "npm install babel-cli -g\n" .
            "npm install babel-preset-env -g\n" .
//            "npm install babel-preset-stage-1 -g\n" .
//            "npm install babel-preset-stage-2 -g\n" .
//            "npm install babel-preset-stage-3 -g\n" .
//            "npm install babel-preset-latest -g\n" .
//            "npm install babel-plugin-transform-remove-strict-mode -g\n" .
            'npm install babel-preset-minify -g')
            ->addOption(
                'es5',
                null,
                InputOption::VALUE_OPTIONAL,
                'Transform JS to ES5?',
                true
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null
     * @throws \WebComplete\mvc\exception\Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var AssetManager $assetManager */
        $assetManager = $this->container->make(AssetManager::class);
        $assetClasses = (array)$input->getArgument('assets');
        $es5 = (bool)$input->getOption('es5');

        foreach ($assetClasses as $assetClass) {
            $internalJs = [];
            /** @var AbstractAsset $asset */
            $asset = $this->container->get($assetClass);
            $assetManager->registerAsset($asset);
            foreach ($asset->internalJs() as $relativeFile) {
                $internalJs[] = $asset->getBasePath() . '/' . \ltrim($relativeFile, '/');
            }
            $outFile = $assetManager->getPath($assetClass, AssetManager::PRODUCTION_JS, true);
            $this->process($internalJs, $outFile, $es5, $output);
        }

        return null;
    }

    /**
     * @param array $files
     * @param string $outFile
     * @param bool $es5
     * @param OutputInterface $output
     */
    protected function process(array $files, string $outFile, bool $es5, OutputInterface $output)
    {
        if ($files) {
            $command = 'babel --no-babelrc --presets ';
            if ($es5) {
                $command .= 'env,';
            }
            $command .= 'minify ' . \implode(' ', $files) . ' -o ' . $outFile;
            \system($command);
            if (\file_exists($outFile)) {
                $output->writeln('File was created: ' . $outFile);
            } else {
                $output->writeln('ERROR File was not created: ' . $outFile);
            }
        }
    }
}
