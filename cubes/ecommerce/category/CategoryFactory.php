<?php

namespace cubes\ecommerce\category;

use WebComplete\core\factory\EntityFactory;

class CategoryFactory extends EntityFactory
{
    protected $objectClass = Category::class;

    /**
     * @return CategoryPropertySettings
     */
    public function createCategoryPropertySettings(): CategoryPropertySettings
    {
        return $this->make(CategoryPropertySettings::class);
    }
}
