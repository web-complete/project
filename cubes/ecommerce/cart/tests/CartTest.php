<?php

namespace cubes\ecommerce\cart\tests;

use cubes\ecommerce\cart\CartService;
use cubes\ecommerce\cartItem\CartItemFactory;
use cubes\ecommerce\cartItem\CartItemService;
use cubes\ecommerce\product\ProductService;

class CartTest extends \AppTestCase
{

    public function testAddProductOffer()
    {
        $productService = $this->container->get(ProductService::class);
        $product = $productService->create();
        $product->setId(1);
        $product->name = 'product1';
        $product->price = 110;

        $cartService = $this->container->get(CartService::class);
        $cart = $cartService->create();
        $this->assertEquals([], $cart->getItems());
        $item = $cart->addProductOffer($product, 3);
        $this->assertEquals([$item], $cart->getItems());
        $this->assertEquals(1, $item->getSku());
        $this->assertEquals('product1', $item->getName());
        $this->assertEquals(110, $item->getPrice());
        $this->assertEquals(3, $item->getQty());
        $this->assertEquals($product, $item->getProductOffer());
    }

    public function testGetSetItems()
    {
        $cartItemFactory = $this->container->get(CartItemFactory::class);
        $item1 = $cartItemFactory->create();
        $item2 = $cartItemFactory->create();
        $item3 = $cartItemFactory->create();
        $cartService = $this->container->get(CartService::class);
        $cart = $cartService->create();
        $this->assertEquals([], $cart->getItems());
        $cart->setItems([$item1, $item2, $item3]);
        $this->assertSame([$item1, $item2, $item3], $cart->getItems());
    }

    public function testGetItemBy()
    {
        $productService = $this->container->get(ProductService::class);
        $product1 = $productService->create();
        $product2 = $productService->create();
        $product3 = $productService->create();
        $productService->save($product1);
        $productService->save($product2);
        $productService->save($product3);

        $cartItemFactory = $this->container->get(CartItemFactory::class);
        $item1 = $cartItemFactory->createFromProductOffer($product1);
        $item2 = $cartItemFactory->createFromProductOffer($product2);
        $item3 = $cartItemFactory->createFromProductOffer($product3);

        $cartItemService = $this->container->get(CartItemService::class);
        $cartItemService->save($item1);
        $cartItemService->save($item2);
        $cartItemService->save($item3);
        $this->assertEquals(1, $item1->getId());
        $this->assertEquals(2, $item2->getId());
        $this->assertEquals(3, $item3->getId());

        $cartService = $this->container->get(CartService::class);
        $cart = $cartService->create();
        $cart->setItems([$item1, $item2, $item3]);
        $this->assertEquals($item1->getId(), $cart->getItemById(1)->getId());
        $this->assertEquals($item2->getId(), $cart->getItemById(2)->getId());
        $this->assertEquals($item3->getId(), $cart->getItemById(3)->getId());
        $this->assertEquals($item1->getId(), $cart->getItemBySku(1)->getId());
        $this->assertEquals($item2->getId(), $cart->getItemBySku(2)->getId());
        $this->assertEquals($item3->getId(), $cart->getItemBySku(3)->getId());
    }

    public function testGetSetTotals()
    {
        $cartService = $this->container->get(CartService::class);
        $cart = $cartService->create();
        $this->assertEquals([], $cart->getTotals());
        $cart->setTotals(['subtotal' => 110, 'total' => 100]);
        $this->assertEquals(['subtotal' => 110, 'total' => 100], $cart->getTotals());
    }

    public function testDeleteItem()
    {
        $cartItemService = $this->container->get(CartItemService::class);
        $item1 = $cartItemService->create();
        $item2 = $cartItemService->create();
        $item3 = $cartItemService->create();
        $cartItemService->save($item1);
        $cartItemService->save($item2);
        $cartItemService->save($item3);

        $cartService = $this->container->get(CartService::class);
        $cart = $cartService->create();
        $cart->setItems([$item1, $item2, $item3]);
        $cartService->save($cart);

        $cart = $cartService->findById($cart->getId());
        $this->assertCount(3, $cart->getItems());

        $cart->deleteItem($item2);
        $this->assertCount(2, $cart->getItems());

        $cartService->save($cart);
        $cart = $cartService->findById($cart->getId());
        $this->assertCount(2, $cart->getItems());
        $this->assertNotNull($cartItemService->findById($item1->getId()));
        $this->assertNotNull($cartItemService->findById($item3->getId()));
        $this->assertNull($cartItemService->findById($item2->getId()));
    }
}
