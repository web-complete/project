<?php

namespace cubes\seo\seo;

interface SeoMetaInterface
{
    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @return string
     */
    public function getKeywords(): string;

    /**
     * @return SeoMetaOG
     */
    public function getMetaOG(): SeoMetaOG;

    /**
     * @return SeoMetaJsonLD
     */
    public function getMetaJsonLD(): SeoMetaJsonLD;
}
