<?php

namespace modules\admin\commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WebComplete\core\utils\alias\AliasService;

class AdminInitCommand extends Command
{

    /**
     * @var AliasService
     */
    private $aliasService;

    /**
     * @param AliasService $aliasService
     */
    public function __construct(AliasService $aliasService)
    {
        parent::__construct();
        $this->aliasService = $aliasService;
    }

    protected function configure()
    {
        $this->setName('admin:init')
            ->setDescription('Init a project');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return null|int
     * @throws \Symfony\Component\Console\Exception\LogicException
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->initDir('@storage', 0770, $output);
        $this->initDir('@storage/micro-db', 0770, $output);
        $this->initDir('@runtime', 0770, $output);
        $this->initDir('@runtime/logs', 0770, $output);
        $this->initDir('@web/assets', 0775, $output);
        $this->initDir('@web/usr', 0770, $output);
        return null;
    }

    /**
     * @param $dir
     * @param int $mode
     * @param OutputInterface $output
     */
    protected function initDir($dir, int $mode, OutputInterface $output)
    {
        $dir = $this->aliasService->get($dir);
        if (!\file_exists($dir)) {
            if (!\mkdir($dir, $mode, true)) {
                $output->writeln('<error>Cannot create directory: ' . $dir . '</error>');
                return;
            }
            $output->writeln('<info>Directory created: ' . $dir . '</info>');
        }
        if (!\is_writable($dir)) {
            $output->writeln('<error>Directory is not writable: ' . $dir . '</error>');
            return;
        }
    }
}
