<?php

namespace cubes\ecommerce\cart\tests;

use cubes\ecommerce\cart\CartService;
use cubes\ecommerce\cartItem\CartItemFactory;
use cubes\ecommerce\cartItem\CartItemService;
use cubes\ecommerce\product\ProductService;
use cubes\ecommerce\productOffer\ProductOfferItem;
use cubes\ecommerce\productOffer\ProductOfferItemService;

class CartTest extends \AppTestCase
{

    public function testCheckout()
    {
        $cartService = $this->container->get(CartService::class);
        $cart = $cartService->create();
        $checkoutData = [
            'first_name' => 'FirstName1',
            'last_name' => 'LastName1',
            'email' => 'email1@example.com'
        ];
        $cart->getCheckout()->setData($checkoutData);
        $this->assertEquals($checkoutData, $cart->getCheckout()->getData());
        $cartService->save($cart);
        $cart = $cartService->findById($cart->getId());
        $this->assertEquals($checkoutData, $cart->getCheckout()->getData());
    }

    public function testAddProductOffer()
    {
        $productService = $this->container->get(ProductOfferItemService::class);
        $product = $productService->create();
        $product->setId(1);
        $product->sku = 'sku1';
        $product->name = 'product1';
        $product->price = 110;

        $cartService = $this->container->get(CartService::class);
        $cart = $cartService->create();
        $this->assertEquals([], $cart->getItems());
        $item = $cart->addProductOffer($product, 3);
        $this->assertEquals([$item], $cart->getItems());
        $this->assertEquals('sku1', $item->getSku());
        $this->assertEquals('product1', $item->getName());
        $this->assertEquals(110, $item->getPrice());
        $this->assertEquals(3, $item->getQty());
        $this->assertEquals($product, $item->getProductOffer());
    }

    public function testGetSetItems()
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
        $this->assertEquals([], $cart->getItems());
        $cart->setItems([$item1, $item2, $item3]);
        $this->assertSame([$item1, $item2, $item3], $cart->getItems());
    }

    public function testGetItemBy()
    {
        $productService = $this->container->get(ProductOfferItemService::class);

        $products = [];
        for ($i= 1; $i <= 3; $i++) {
            $product = $productService->create();
            $product->setId($i);
            $product->sku = 'sku' . $i;
            $product->name = 'product' . $i;
            $product->price = $i;
            $productService->save($product);
            $products[] = $product;
        }

        $cartItemFactory = $this->container->get(CartItemFactory::class);
        $item1 = $cartItemFactory->createFromProductOffer($products[0]);
        $item2 = $cartItemFactory->createFromProductOffer($products[1]);
        $item3 = $cartItemFactory->createFromProductOffer($products[2]);

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
        $this->assertEquals($item1->getId(), $cart->getItemBySku('sku1')->getId());
        $this->assertEquals($item2->getId(), $cart->getItemBySku('sku2')->getId());
        $this->assertEquals($item3->getId(), $cart->getItemBySku('sku3')->getId());
    }

    public function testGetSetTotals()
    {
        $cartService = $this->container->get(CartService::class);
        $cart = $cartService->create();
        $this->assertEmpty($cart->getTotals());
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

    public function testSetItemsWithoutIdThrowsException()
    {
        $this->expectException(\RuntimeException::class);
        $cartItemService = $this->container->get(CartItemService::class);
        $item = $cartItemService->create();
        $cartService = $this->container->get(CartService::class);
        $cart = $cartService->create();
        $cart->setItems([$item]);
    }
}
