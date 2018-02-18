<?php

namespace cubes\ecommerce\property;

use cubes\ecommerce\property\property\PropertyAbstract;

/**
 * @internal
 * @package cubes\ecommerce\property
 */
trait PropertyBagTrait
{
    /**
     * @var PropertyAbstract[]
     */
    protected $properties = [];

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
     * @return PropertyAbstract[]
     */
    public function allForMain(): array
    {
        $result = [];
        foreach ($this->all() as $property) {
            if ($property->for_main) {
                $result[] = $property;
            }
        }
        return $result;
    }

    /**
     * @return PropertyAbstract[]
     */
    public function allForList(): array
    {
        $result = [];
        foreach ($this->all() as $property) {
            if ($property->for_list) {
                $result[] = $property;
            }
        }
        return $result;
    }

    /**
     * @return PropertyAbstract[]
     */
    public function allForFilter(): array
    {
        $result = [];
        foreach ($this->all() as $property) {
            if ($property->for_filter) {
                $result[] = $property;
            }
        }
        return $result;
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
