<?php

namespace cubes\system\seo\seo;

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
     * @return string
     */
    public function getCanonical(): string;

    /**
     * @return bool
     */
    public function getNoindex(): bool;

    /**
     * @return SeoMetaOG
     */
    public function getMetaOG(): SeoMetaOG;
}
