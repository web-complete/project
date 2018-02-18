<?php

namespace cubes\ecommerce\property;

use cubes\ecommerce\property\property\PropertyAbstract;
use cubes\ecommerce\property\property\PropertyFactory;
use cubes\system\logger\Log;

class PropertyBag
{
    /**
     * @var PropertyFactory
     */
    protected $factory;
    /**
     * @var PropertyAbstract[]
     */
    protected $properties = [];

    /**
     * @param PropertyFactory $factory
     */
    public function __construct(PropertyFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return array
     */
    public function mapToArray(): array
    {
        $result = [];
        foreach ($this->properties as $property) {
            $result[] = $property->mapToArray();
        }
        return $result;
    }

    /**
     * @param array $data
     */
    public function mapFromArray(array $data)
    {
        $this->properties = [];
        foreach ($data as $itemData) {
            try {
                $this->properties[] = $this->factory->create((array)$itemData);
            } catch (\RuntimeException $e) {
                Log::exception($e);
            }
        }
    }

    /**
     * @param PropertyAbstract $property
     */
    public function add(PropertyAbstract $property)
    {
        $this->properties[] = $property;
    }

    /**
     * @param string $code
     */
    public function remove(string $code)
    {
        foreach ($this->properties as $k => $property) {
            if ($property->code === $code) {
                unset($this->properties[$k]);
            }
        }
    }

    /**
     * @return PropertyAbstract[]
     */
    public function all(): array
    {
        return $this->properties;
    }

    /**
     * @param string $code
     *
     * @return PropertyAbstract|null
     */
    public function one(string $code)
    {
        foreach ($this->all() as $property) {
            if ($property->code === $code) {
                 return $property;
            }
        }
        return null;
    }

    /**
     * @param string $code
     *
     * @return bool
     */
    public function has(string $code): bool
    {
        foreach ($this->all() as $property) {
            if ($property->code === $code) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param PropertyBag $properties
     */
    public function merge(PropertyBag $properties)
    {
        foreach ($properties->all() as $property) {
            $this->add($property);
        }
        $this->sort();
    }

    /**
     */
    public function sort()
    {
        \usort($this->properties, function (PropertyAbstract $prop1, PropertyAbstract $prop2) {
            return $prop1->sort <=> $prop2->sort;
        });
    }
}
