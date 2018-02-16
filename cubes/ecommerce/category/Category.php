<?php

namespace cubes\ecommerce\category;

use cubes\ecommerce\property\PropertyService;
use WebComplete\core\entity\AbstractEntity;

/**
*
* @property $name
*/
class Category extends AbstractEntity
{

    /**
     * @var PropertyService
     */
    protected $propertyService;

    /**
     * @param PropertyService $propertyService
     */
    public function __construct(PropertyService $propertyService)
    {
        $this->propertyService = $propertyService;
    }

    /**
     * @return array
     */
    public static function fields(): array
    {
        return CategoryConfig::getFieldTypes();
    }

    /**
     * @return array
     */
    public function getProperties(): array
    {
        // TODO runtime cache
        $globalProperties = $this->propertyService->getGlobalProperties();
        return \array_merge($globalProperties, $this->get('properties') ?: []);
    }
}
