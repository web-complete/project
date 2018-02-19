<?php

namespace cubes\ecommerce\product\tests;

use cubes\ecommerce\category\Category;
use cubes\ecommerce\category\CategoryFactory;
use cubes\ecommerce\category\CategoryService;
use cubes\ecommerce\product\Product;
use cubes\ecommerce\product\ProductService;
use cubes\ecommerce\property\property\PropertyFactory;
use cubes\ecommerce\property\PropertyService;
use cubes\system\multilang\lang\Lang;
use cubes\system\multilang\lang\LangService;

/**
 * Class PropsTest
 */
class PropsTest extends \AppTestCase
{
    public function testProperties()
    {
        $this->createLangs();
        $this->createGlobalProperties();
        $category = $this->createCategory();
        $product = $this->createProduct($category);

        $this->assertNotNull($product->getId());
        $this->assertEquals([
            [
                'uid' => '1',
                'code' => 'prop1',
                'name' => 'Property 1',
                'type' => 'string',
                'sort' => 1000,
                'global' => 1,
                'enabled' => 1,
                'for_main' => 0,
                'for_list' => 1,
                'for_filter' => 1,
                'data' => [],
                'multilang' => [],
            ],
            [
                'uid' => '2',
                'code' => 'prop2',
                'name' => 'Property 2',
                'type' => 'string',
                'sort' => 1001,
                'global' => 0,
                'enabled' => 1,
                'for_main' => 1,
                'for_list' => 0,
                'for_filter' => 1,
                'data' => [],
                'multilang' => [],
            ],
        ], $category->getPropertyBag(true)->mapToArray());
        $productProperties = $product->getPropertyBag();
        $this->assertEquals('val1ru', $product->getPropertyValue('prop1'));
        $this->assertEquals('val2ru', $product->getPropertyValue('prop2'));
        $this->assertEquals('val1ru', $productProperties->one('prop1')->getValue());
        $this->assertEquals('val2ru', $productProperties->one('prop2')->getValue());
        $product->setLang('ru');
        $this->assertEquals('val1ru', $productProperties->one('prop1')->getValue());
        $this->assertEquals('val2ru', $productProperties->one('prop2')->getValue());
        $product->setLang('en');
        $this->assertEquals('val1en', $product->getPropertyValue('prop1'));
        $this->assertEquals('val2en', $product->getPropertyValue('prop2'));
        $this->assertEquals('val1en', $productProperties->one('prop1')->getValue());
        $this->assertEquals('val2en', $productProperties->one('prop2')->getValue());
    }

    protected function createLangs()
    {
        $langService = $this->container->get(LangService::class);
        /** @var Lang $lang1 */
        $lang1 = $langService->create();
        $lang1->code = 'ru';
        $lang1->is_main = 1;
        $langService->save($lang1);
        /** @var Lang $lang2 */
        $lang2 = $langService->create();
        $lang2->code = 'en';
        $lang2->is_main = 0;
        $langService->save($lang2);
    }

    protected function createGlobalProperties()
    {
        $propertyService = $this->container->get(PropertyService::class);
        $propertyFactory = $this->container->get(PropertyFactory::class);
        $bag = $propertyService->createBag();
        $bag->add($propertyFactory->create([
            'uid' => 1,
            'code' => 'prop1',
            'name' => 'Property 1',
            'type' => 'string',
            'sort' => 1000,
            'global' => 1,
            'enabled' => 1,
            'for_main' => 1,
        ]));
        $propertyService->setGlobalProperties($bag);
    }

    /**
     * @return Category
     */
    protected function createCategory(): Category
    {
        $propertyService = $this->container->get(PropertyService::class);
        $propertyFactory = $this->container->get(PropertyFactory::class);
        $bag = $propertyService->createBag();
        $bag->add($propertyFactory->create([
            'uid' => 2,
            'code' => 'prop2',
            'name' => 'Property 2',
            'type' => 'string',
            'sort' => 1001,
            'global' => 0,
            'enabled' => 1,
            'for_list' => 1,
        ]));
        $categoryFactory = $this->container->get(CategoryFactory::class);
        $propertySettings = $categoryFactory->createCategoryPropertySettings();
        $propertySettings->enabled = ['prop1', 'prop2'];
        $propertySettings->for_main = ['prop2'];
        $propertySettings->for_list = ['prop1'];
        $propertySettings->for_filter = ['prop1', 'prop2'];

        $categoryService = $this->container->get(CategoryService::class);
        /** @var Category $category */
        $category = $categoryService->create();
        $category->name = 'Category 1';
        $category->setProperties($bag, $propertySettings);
        $categoryService->save($category);
        return $category;
    }

    /**
     * @param Category $category
     *
     * @return Product
     */
    protected function createProduct(Category $category): Product
    {
        $productService = $this->container->get(ProductService::class);
        $product = $productService->create();
        $product->name = 'Product 1';
        $product->category_id = $category->getId();
        $product->setPropertiesValues(
            ['prop1' => 'val1ru', 'prop2' => 'val2ru'],
            ['prop1' => ['en' => 'val1en'], 'prop2' => ['en' => 'val2en']]
        );
        $productService->save($product);
        return $product;
    }
}
