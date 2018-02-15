<?php

namespace cubes\system\seo\sitemap;

class SeoSitemapProcessor
{
    /**
     * @var SeoSitemapInterface
     */
    private $sitemap;

    /**
     * @param SeoSitemapInterface $sitemap
     */
    public function __construct(SeoSitemapInterface $sitemap)
    {
        $this->sitemap = $sitemap;
    }

    /**
     */
    public function run()
    {
        $this->sitemap->generate();
    }
}
