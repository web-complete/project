<?php

namespace cubes\ecommerce\category;

use cubes\ecommerce\property\PropertyBag;
use cubes\ecommerce\property\PropertyService;
use cubes\system\multilang\lang\classes\AbstractMultilangEntity;

/**
*
* @property $name
*/
class Category extends AbstractMultilangEntity
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
        $propertiesSettings = (array)$this->get('properties_settings', []);
        $propertiesEnabled = (array)($propertiesSettings['enabled'] ?? []);
        $propertiesForMain = (array)($propertiesSettings['for_main'] ?? []);
        $propertiesForList = (array)($propertiesSettings['for_list'] ?? []);
        $propertiesForFilter = (array)($propertiesSettings['for_filter'] ?? []);

        $categoryProperties = $this->propertyService->createBag($this->get('properties') ?? []);
        $properties = $this->propertyService->getGlobalPropertyBag(true);
        $properties->merge($categoryProperties);
        foreach ($properties->all() as $property) {
            $property->enabled = !$this->getId() || \in_array($property->code, $propertiesEnabled, true);
            if ($onlyEnabled && !$property->enabled) {
                $properties->remove($property->code);
                continue;
            }
            if ($this->getId()) {
                $property->for_main = \in_array($property->code, $propertiesForMain, true);
                $property->for_list = \in_array($property->code, $propertiesForList, true);
                $property->for_filter = \in_array($property->code, $propertiesForFilter, true);
            }
        }
        return $properties;
    }

    /**
     * @param PropertyBag $propertyBag
     * @param CategoryPropertySettings $settings
     */
    public function setProperties(PropertyBag $propertyBag, CategoryPropertySettings $settings)
    {
        $this->set('properties', $propertyBag->mapToArray());
        $this->set('properties_settings', $settings->mapToArray());
    }
}
