<?php

namespace cubes\search\search\commands;

use cubes\search\search\SearchService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SearchClearCommand extends Command
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
        $this->setName('search:clear')->setDescription('Clear search index');
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
        $output->writeln('Done!');
        return null;
    }
}
