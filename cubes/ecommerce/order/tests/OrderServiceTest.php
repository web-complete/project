<?php

namespace cubes\ecommerce\order\tests;

use cubes\ecommerce\cart\CartService;
use cubes\ecommerce\order\OrderService;
use cubes\ecommerce\product\ProductService;
use cubes\ecommerce\productOffer\ProductOfferItemService;

class OrderServiceTest extends \AppTestCase
{

    public function testCreateOrder()
    {
        // создать товары
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

        // добавить в корзину
        $cartService = $this->container->get(CartService::class);
        $cart = $cartService->current();
        $cart->addProductOffer($products[0]);
        $cart->addProductOffer($products[1]);
        $cart->addProductOffer($products[2]);
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
