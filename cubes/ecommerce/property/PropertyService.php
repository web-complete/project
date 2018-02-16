<?php

namespace cubes\ecommerce\property;

use cubes\system\storage\Storage;

class PropertyService
{
    const STORAGE_GLOBAL_PROPERTIES = 'ecommerce:properties';

    /**
     * @var Storage
     */
    protected $storage;

    /**
     * @param Storage $storage
     */
    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @return PropertyBag
     */
    public function getGlobalProperties(): PropertyBag
    {
        $data = (array)$this->storage->get(self::STORAGE_GLOBAL_PROPERTIES, []);
        return new PropertyBag($data);
    }

    /**
     * @param PropertyBag $propertyBag
     */
    public function setGlobalProperties(PropertyBag $propertyBag)
    {
        $this->storage->set(self::STORAGE_GLOBAL_PROPERTIES, $propertyBag->mapToArray());
    }
}
