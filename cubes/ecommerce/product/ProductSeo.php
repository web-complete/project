<?php

namespace cubes\ecommerce\product;

use cubes\system\seo\seo\AbstractEntitySeo;

class ProductSeo extends AbstractEntitySeo
{
    public $entityServiceClass = ProductService::class;
    public $titleField = 'name';
    public $urlPrefix = '/product';
}
