<?php

namespace cubes\ecommerce\property;

use cubes\ecommerce\property\property\PropertyFactory;
use cubes\system\logger\Log;

/**
 * @package cubes\ecommerce\property
 */
class PropertyBag
{
    use /** @noinspection PhpInternalEntityUsedInspection */ PropertyBagTrait;

    /**
     * @var PropertyFactory
     */
    protected $factory;
    protected $currentLangCode;

    /**
     * @param PropertyFactory $factory
     */
    public function __construct(PropertyFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param string|null $code
     *
     * @return $this
     */
    public function setLang(string $code = null): self
    {
        $this->currentLangCode = $code;
        foreach ($this->all() as $property) {
            $property->setLang($this->currentLangCode);
        }
        return $this;
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
}
