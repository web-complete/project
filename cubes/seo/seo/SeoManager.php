<?php

namespace cubes\seo\seo;

class SeoManager
{
    protected $seoMeta;

    public function registerSeoMeta(SeoMetaInterface $seoMeta)
    {
        $this->seoMeta = $seoMeta;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return '';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return '';
    }

    /**
     * @return string
     */
    public function getKeywords(): string
    {
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
}
