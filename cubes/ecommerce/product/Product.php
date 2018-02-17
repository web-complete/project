<?php

namespace cubes\ecommerce\product;

use cubes\ecommerce\category\Category;
use cubes\ecommerce\category\CategoryService;
use cubes\ecommerce\interfaces\ProductOfferInterface;
use cubes\ecommerce\property\property\PropertyAbstract;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\utils\cache\CacheRuntime;

/**
*
* @property string $name
* @property string $category_id
* @property float $price
*/
class Product extends AbstractEntity implements ProductOfferInterface
{
    /**
     * @var CategoryService
     */
    protected $categoryService;
    protected $runtimeProperties;

    /**
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @return array
     */
    public static function fields(): array
    {
        return ProductConfig::getFieldTypes();
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return (string)$this->getId();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return (string)$this->name;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return (float)$this->price;
    }

    /**
     * @return Category|null
     */
    public function getCategory()
    {
        return CacheRuntime::getOrSet(['category', $this->category_id], function () {
            return $this->category_id
                ? $this->categoryService->findById($this->category_id)
                : null;
        });
    }

    /**
     * @return PropertyAbstract[]
     */
    public function getProperties(): array
    {
        if ($this->runtimeProperties === null) {
            $this->runtimeProperties = [];
            if ($category = $this->getCategory()) {
                $propertyValues = (array)($this->get('properties') ?? []);
                $properties = $category->getPropertyBag(true);
                foreach ($properties->all() as $property) {
                    $property->setValue($propertyValues[$property->code] ?? null);
                    $this->runtimeProperties[] = $property;
                }
            }
        }

        return $this->runtimeProperties;
    }
}
