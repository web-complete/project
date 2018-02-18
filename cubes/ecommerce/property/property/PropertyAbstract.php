<?php

namespace cubes\ecommerce\property\property;

use WebComplete\core\utils\traits\TraitData;
use WebComplete\core\utils\typecast\Cast;

/**
 *
 * @property $uid
 * @property $code
 * @property $name
 * @property $type
 * @property $sort
 * @property $global
 * @property $enabled
 * @property $for_main
 * @property $for_list
 * @property $for_filter
 * @property array $data
 * @property array $multilang
 */
abstract class PropertyAbstract
{
    use TraitData;

    protected $value;
    protected $currentLangCode;

    /**
     * @return array
     */
    public static function fields(): array
    {
        return [
            'uid' => Cast::STRING,
            'code' => Cast::STRING,
            'name' => Cast::STRING,
            'type' => Cast::STRING,
            'sort' => Cast::INT,
            'global' => Cast::INT,
            'enabled' => Cast::INT,
            'for_main' => Cast::INT,
            'for_list' => Cast::INT,
            'for_filter' => Cast::INT,
            'data' => Cast::ARRAY,
            'multilang' => Cast::ARRAY,
        ];
    }

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->mapFromArray($data);
    }

    /**
     * @param string|null $code
     *
     * @return $this
     */
    public function setLang(string $code = null): self
    {
        $this->currentLangCode = $code;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        if ($this->currentLangCode) {
            return $this->multilang[$this->currentLangCode] ?? $this->value;
        }
        return $this->value;
    }

    /**
     * @param $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}
