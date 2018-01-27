<?php

namespace cubes\seo\seo;

use cubes\seo\meta\Meta;
use cubes\seo\meta\MetaService;
use cubes\system\settings\Settings;
use Symfony\Component\HttpFoundation\Request;

class SeoManager
{
    /**
     * @var MetaService
     */
    protected $metaService;
    /**
     * @var Meta
     */
    protected $currentPageMeta;
    /**
     * @var SeoMetaInterface
     */
    protected $seoMeta;
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Settings
     */
    protected $settings;

    /**
     * @param MetaService $metaService
     * @param Request $request
     * @param Settings $settings
     */
    public function __construct(MetaService $metaService, Request $request, Settings $settings)
    {
        $this->metaService = $metaService;
        $this->request = $request;
        $this->settings = $settings;
    }

    /**
     * @param SeoMetaInterface $seoMeta
     */
    public function registerSeoMeta(SeoMetaInterface $seoMeta)
    {
        $this->seoMeta = $seoMeta;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        $title = $this->getCurrentPageMeta()->title;
        if (!$title && $this->seoMeta) {
            $title = $this->seoMeta->getTitle();
        }

        $siteName = $this->settings->get('site_name');
        if ($siteName && $title) {
            return $siteName . ' - ' . $title;
        }
        if (!$title) {
            return $siteName;
        }
        if (!$siteName) {
            return $title;
        }
        return '';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        $description = $this->getCurrentPageMeta()->description;
        if (!$description && $this->seoMeta) {
            $description = $this->seoMeta->getTitle();
        }
        if (!$description) {
            $description = $this->settings->get('site_description');
        }

        return $description;
    }

    /**
     * @return string
     */
    public function getKeywords(): string
    {
        if ($title = $this->getCurrentPageMeta()->keywords) {
            return $title;
        }
        if ($this->seoMeta) {
            return $this->seoMeta->getKeywords();
        }
        return '';
    }

    /**
     * @return string
     */
    public function getMetaOG(): string
    {
        return '';
    }

    /**
     * @return string
     */
    public function getMetaJsonLD(): string
    {
        return '';
    }

    /**
     * @return Meta
     */
    public function getCurrentPageMeta(): Meta
    {
        if (!$this->currentPageMeta) {
            $url = \parse_url($this->request->getRequestUri(), \PHP_URL_PATH);
            $condition = $this->metaService->createCondition(['url' => $url]);
            if (!$this->currentPageMeta = $this->metaService->findOne($condition)) {
                $this->currentPageMeta = $this->metaService->create();
            }
        }
        return $this->currentPageMeta;
    }
}
