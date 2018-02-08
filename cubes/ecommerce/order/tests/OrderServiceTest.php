<?php

namespace cubes\ecommerce\order\tests;

use cubes\ecommerce\cart\CartService;
use cubes\ecommerce\order\OrderService;
use cubes\ecommerce\product\ProductService;

class OrderServiceTest extends \AppTestCase
{

    public function testCreateOrder()
    {
        // создать товары
        $productService = $this->container->get(ProductService::class);
        $product1 = $productService->create();
        $product2 = $productService->create();
        $product3 = $productService->create();
        $productService->save($product1);
        $productService->save($product2);
        $productService->save($product3);

        // добавить в корзину
        $cartService = $this->container->get(CartService::class);
        $cart = $cartService->current();
        $cart->addProductOffer($product1);
        $cart->addProductOffer($product2);
        $cart->addProductOffer($product3);
        $cartService->save($cart);
        $this->assertNotEmpty($cart->getId());

        // создать чекаут (получить текущий)
        $checkoutData = [
            'first_name' => 'FirstName1',
            'last_name' => 'LastName1',
            'email' => 'email1@example.com'
        ];
        $cart->getCheckout()->setData($checkoutData);
        $this->assertEquals($checkoutData, $cart->getCheckout()->getData());

        // создать заказ + сбросить корзину и чекаут
        $orderService = $this->container->get(OrderService::class);
        $order = $orderService->createOrder($cart);

        // проверить заказ
        $this->assertNotEmpty($order->getId());
        $items = $order->getItems();
        $this->assertCount(3, $items);
        $this->assertEquals(1, $items[0]->getProductData()['id']);
        $this->assertEquals(2, $items[1]->getProductData()['id']);
        $this->assertEquals(3, $items[2]->getProductData()['id']);
        $this->assertEquals($cart->getTotals(), $order->getTotals());
        $this->assertEquals($checkoutData, $order->getCheckout()->getData());

        // проверить что корзина(+чекаут) удалена/сброшена
        $this->assertNull($cartService->findById($cart->getId()));
    }
}
