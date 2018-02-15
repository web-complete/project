<?php

namespace cubes\system\search\search\commands;

use cubes\system\search\search\SearchService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SearchCountCommand extends Command
{
    /**
     * @var SearchService
     */
    private $searchService;

    /**
     * @param SearchService $searchService
     */
    public function __construct(SearchService $searchService)
    {
        parent::__construct(null);
        $this->searchService = $searchService;
    }

    /**
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure()
    {
        $this->setName('search:count')->setDescription('Count search index');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return null|int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->searchService->clear();
        $output->writeln('Count: ' . $this->searchService->count());
        $output->writeln('Done!');
        return null;
    }
}
