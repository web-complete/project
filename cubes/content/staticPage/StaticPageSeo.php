<?php

namespace cubes\content\staticPage;

use cubes\seo\seo\AbstractEntitySeo;

class StaticPageSeo extends AbstractEntitySeo
{
    protected $entityServiceClass = StaticPageService::class;
    protected $titleField = 'title';
    protected $urlPrefix = '/page';
}
