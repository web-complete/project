<?php

namespace cubes\ecommerce\property;

use cubes\ecommerce\property\property\PropertyFactory;
use cubes\system\storage\Storage;

class PropertyService
{
    const STORAGE_GLOBAL_PROPERTIES = 'ecommerce:properties';

    /**
     * @var Storage
     */
    protected $storage;
    /**
     * @var PropertyFactory
     */
    protected $propertyFactory;

    /**
     * @param Storage $storage
     */
    public function __construct(Storage $storage, PropertyFactory $propertyFactory)
    {
        $this->storage = $storage;
        $this->propertyFactory = $propertyFactory;
    }

    /**
     * @param array $data
     *
     * @return PropertyBag
     */
    public function createBag(array $data = []): PropertyBag
    {
        $properties = new PropertyBag($this->propertyFactory);
        $properties->mapFromArray($data);
        return $properties;
    }

    /**
     * @param bool $onlyEnabled
     *
     * @return PropertyBag
     */
    public function getGlobalPropertyBag(bool $onlyEnabled = false): PropertyBag
    {
        $data = (array)$this->storage->get(self::STORAGE_GLOBAL_PROPERTIES, []);
        $properties = $this->createBag($data);
        if ($onlyEnabled) {
            foreach ($properties->all() as $property) {
                if (!$property->enabled) {
                    $properties->remove($property->code);
                }
            }
        }
        return $properties;
    }

    /**
     * @param PropertyBag $propertyBag
     */
    public function setGlobalProperties(PropertyBag $propertyBag)
    {
        $this->storage->set(self::STORAGE_GLOBAL_PROPERTIES, $propertyBag->mapToArray());
    }
}
