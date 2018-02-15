<?php

namespace modules\pub\classes;

use cubes\system\seo\sitemap\SeoSitemapInterface;
use cubes\system\settings\Settings;
use samdark\sitemap\Sitemap;
use WebComplete\core\utils\alias\AliasService;

class SeoSitemap implements SeoSitemapInterface
{

    public $staticModifications = Sitemap::MONTHLY;

    /** @var array [url, priority] */
    public $staticPages = [
        ['/', 1],
    ];

    /**
     * @var Settings
     */
    protected $settings;
    /**
     * @var AliasService
     */
    protected $aliasService;
    protected $prefix;

    /**
     * @param Settings $settings
     * @param AliasService $aliasService
     */
    public function __construct(Settings $settings, AliasService $aliasService)
    {
        $this->settings = $settings;
        $this->aliasService = $aliasService;
    }

    /**
     * @throws \InvalidArgumentException
     * @throws \WebComplete\core\utils\alias\AliasException
     * @throws \RuntimeException
     */
    public function generate()
    {
        if (!$siteDomain = $this->settings->get('site_domain')) {
            throw new \RuntimeException('Settings: site_domain is not defined');
        }
        $this->prefix = 'http://' . $siteDomain;
        $sitemap = new Sitemap($this->aliasService->get('@web/sitemap.xml'));
        $this->generateStaticPages($sitemap);
        $this->generateDynamicPages($sitemap);
        $sitemap->write();
    }

    /**
     * @param Sitemap $sitemap
     *
     * @throws \InvalidArgumentException
     */
    protected function generateStaticPages(Sitemap $sitemap)
    {
        foreach ($this->staticPages as $row) {
            $sitemap->addItem($this->prefix . $row[0], null, $this->staticModifications, $row[1]);
        }
    }

    /**
     * @param Sitemap $sitemap
     */
    protected function generateDynamicPages(Sitemap $sitemap)
    {
        // TODO example:
//        if($items = $articleService->findAll(['f_active' => 1])) {
//            /** @var Article $item */
//            foreach ($items as $item) {
//                $time = $item->updated_on ? \strtotime($item->updated_on) : \strtotime($item->created_on);
//                $sitemap->addItem($this->prefix . $item->getUrl(), $time, Sitemap::MONTHLY, 0.5);
//            }
//        }
    }
}
