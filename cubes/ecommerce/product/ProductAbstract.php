<?php

namespace cubes\ecommerce\product;

use cubes\ecommerce\category\Category;
use cubes\ecommerce\category\CategoryService;
use cubes\ecommerce\property\property\PropertyAbstract;
use cubes\ecommerce\property\PropertyBag;
use cubes\ecommerce\property\PropertyService;
use cubes\system\multilang\lang\classes\AbstractMultilangEntity;
use WebComplete\core\utils\cache\CacheRuntime;

/**
 *
 * @property string $sku
 * @property string $name
 * @property string $category_id
 * @property float $price
 */
abstract class ProductAbstract extends AbstractMultilangEntity
{
    /**
     * @var CategoryService
     */
    protected $categoryService;
    /**
     * @var PropertyService
     */
    protected $propertyService;
    private $runtimePropertyBag;

    /**
     * @return array
     */
    public static function fields(): array
    {
        return ProductConfig::getFieldTypes();
    }


    /**
     * @param CategoryService $categoryService
     * @param PropertyService $propertyService
     */
    public function __construct(CategoryService $categoryService, PropertyService $propertyService)
    {
        $this->categoryService = $categoryService;
        $this->propertyService = $propertyService;
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return (string)$this->sku;
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
     * @param string|null $code
     *
     * @return $this|AbstractMultilangEntity
     */
    public function setLang(string $code = null)
    {
        $this->getPropertyBag()->setLang($code);
        return parent::setLang($code);
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
     * @return PropertyBag
     */
    public function getPropertyBag(): PropertyBag
    {
        if ($this->runtimePropertyBag === null) {
            $this->runtimePropertyBag = $this->propertyService->createBag();

            if ($category = $this->getCategory()) {
                $propertiesValues = (array)($this->get('properties') ?? []);
                $propertiesMultilangData = (array)($this->get('properties_multilang') ?? []);

                $propertyBag = $category->getPropertyBag(true);
                foreach ($propertyBag->all() as $property) {
                    $property->setValue($propertiesValues[$property->code] ?? null);
                    $property->multilang = (array)($propertiesMultilangData[$property->code] ?? []);
                }
                $this->runtimePropertyBag = $propertyBag;
            }
        }

        return $this->runtimePropertyBag;
    }

    /**
     * @param string $code
     *
     * @return PropertyAbstract|null
     */
    public function getProperty(string $code)
    {
        return $this->getPropertyBag()->one($code);
    }

    /**
     * @param string $code
     * @param null $default
     *
     * @return mixed|null
     */
    public function getPropertyValue(string $code, $default = null)
    {
        $property = $this->getProperty($code);
        return $property ? $property->getValue() : $default;
    }

    /**
     * @param array $propertiesValues [code => value]
     * @param array $multilangData [code => [langCode => value]]
     */
    public function setPropertiesValues(array $propertiesValues, array $multilangData = [])
    {
        if ($category = $this->getCategory()) {
            $propertyBag = $category->getPropertyBag(true);
            $values = [];
            foreach ($propertiesValues as $code => $value) {
                if ($propertyBag->has($code)) {
                    $values[$code] = $value;
                }
            }
            $this->set('properties', $values);
            $this->set('properties_multilang', $multilangData);
        }
    }
}
