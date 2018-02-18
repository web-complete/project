<?php

namespace cubes\ecommerce\property\property;

class PropertyEnum extends PropertyAbstract
{
    /**
     * @return array
     */
    public function getOptions(): array
    {
        $result = [];
        $data = (array)($this->get('data') ?? []);
        $enum = (array)($data['enum'] ?? []);
        foreach ($enum as $enumItem) {
            $code = $enumItem['code'] ?? null;
            $value = $enumItem['value'] ?? null;
            if ($code && $value) {
                $result[$code] = $value;
            }
        }
        return $result;
    }
}
