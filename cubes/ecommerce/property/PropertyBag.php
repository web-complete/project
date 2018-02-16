<?php

namespace cubes\ecommerce\property;

class PropertyBag
{

    /**
     * @var array
     */
    protected $data;

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function mapToArray(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function mapFromArray(array $data)
    {
        $this->data = $data;
    }
}
