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
     * @return SeoMetaOG|null
     */
    public function getMetaOG();

    /**
     * @return SeoMetaJsonLD|null
     */
    public function getJsonLD();
}
