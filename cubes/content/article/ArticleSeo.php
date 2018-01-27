<?php

namespace cubes\content\article;

use cubes\seo\seo\AbstractEntitySeo;

class ArticleSeo extends AbstractEntitySeo
{
    protected $entityServiceClass = ArticleService::class;
    protected $titleField = 'title';
    protected $urlPrefix = '/article';
}
