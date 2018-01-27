<?php

namespace cubes\content\article;

use cubes\seo\seo\AbstractEntitySeo;
use cubes\seo\seo\SeoManager;

class ArticleSeo extends AbstractEntitySeo
{
    /**
     * @param SeoManager $seoManager
     * @param ArticleService $entityService
     */
    public function __construct(SeoManager $seoManager, ArticleService $entityService)
    {
        parent::__construct($seoManager, $entityService);
    }
}
