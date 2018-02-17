<?php

namespace cubes\ecommerce\property\property;

class PropertyFactory
{
    public static $typeMap = [
        'string' => PropertyString::class,
        'bool'   => PropertyBool::class,
        'enum'   => PropertyEnum::class,
        'image'  => PropertyImage::class,
        'images' => PropertyImages::class,
    ];

    /**
     * @param array $data
     *
     * @return PropertyAbstract
     * @throws \RuntimeException
     */
    public function create(array $data): PropertyAbstract
    {
        $type = $data['type'] ?? null;
        if (!isset(self::$typeMap[$type])) {
            throw new \RuntimeException('type not found: ' . $type);
        }

        $class = self::$typeMap[$type];
        return new $class($data);
    }
}
