<?php

namespace cubes\seo\sitemap\commands;

use cubes\seo\sitemap\SeoSitemapProcessor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SitemapCommand extends Command
{
    /**
     * @var SeoSitemapProcessor
     */
    private $sitemapProcessor;

    /**
     * @param SeoSitemapProcessor $sitemapProcessor
     */
    public function __construct(SeoSitemapProcessor $sitemapProcessor)
    {
        parent::__construct(null);
        $this->sitemapProcessor = $sitemapProcessor;
    }

    /**
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure()
    {
        $this->setName('sitemap:generate')->setDescription('Generate sitemap.xml');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return null|int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->sitemapProcessor->run();
        $output->writeln('Done!');
        return null;
    }
}
