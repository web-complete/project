<?php

namespace cubes\ecommerce\category;

use cubes\ecommerce\property\PropertyBag;
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
     * @param bool $onlyEnabled
     *
     * @return PropertyBag
     */
    public function getPropertyBag(bool $onlyEnabled = false): PropertyBag
    {
        $propertiesEnabled = (array)$this->get('properties_enabled');
        $categoryProperties = $this->propertyService->createBag($this->get('properties') ?? []);
        $properties = $this->propertyService->getGlobalPropertyBag(true);
        $properties->merge($categoryProperties);
        foreach ($properties->all() as $property) {
            $property->enabled = !$this->getId() || \in_array($property->code, $propertiesEnabled, true);
            if ($onlyEnabled && !$property->enabled) {
                $properties->remove($property->code);
            }
        }
        return $properties;
    }
}
