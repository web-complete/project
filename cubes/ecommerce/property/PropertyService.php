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
     * @return array
     */
    public function getGlobalProperties(): array
    {
        return (array)$this->storage->get(self::STORAGE_GLOBAL_PROPERTIES, []);
    }

    /**
     * @param array $properties
     */
    public function setGlobalProperties(array $properties)
    {
        $this->storage->set(self::STORAGE_GLOBAL_PROPERTIES, $properties);
    }
}
