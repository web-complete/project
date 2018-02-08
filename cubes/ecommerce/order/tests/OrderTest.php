<?php

namespace cubes\ecommerce\order\tests;

use cubes\ecommerce\order\OrderService;
use cubes\ecommerce\orderItem\OrderItemService;

class OrderTest extends \AppTestCase
{

    public function testCheckout()
    {
        $orderService = $this->container->get(OrderService::class);
        $order = $orderService->create();
        $checkoutData = [
            'first_name' => 'FirstName1',
            'last_name' => 'LastName1',
            'email' => 'email1@example.com'
        ];
        $order->getCheckout()->setData($checkoutData);
        $this->assertEquals($checkoutData, $order->getCheckout()->getData());
        $orderService->save($order);
        $order = $orderService->findById($order->getId());
        $this->assertEquals($checkoutData, $order->getCheckout()->getData());
    }

    public function testSetItems()
    {
        $orderItemService = $this->container->get(OrderItemService::class);
        $item1 = $orderItemService->create();
        $item2 = $orderItemService->create();
        $item3 = $orderItemService->create();
        $orderItemService->save($item1);
        $orderItemService->save($item2);
        $orderItemService->save($item3);

        $orderService = $this->container->get(OrderService::class);
        $order = $orderService->create();
        $order->setItems([$item1, $item2, $item3]);
        $this->assertSame([$item1, $item2, $item3], $order->getItems());
    }

    public function testGetItemBy()
    {
        $orderItemService = $this->container->get(OrderItemService::class);
        $item1 = $orderItemService->create();
        $item2 = $orderItemService->create();
        $item3 = $orderItemService->create();
        $item1->mapFromArray(['id' => 1, 'sku' => 'sku1']);
        $item2->mapFromArray(['id' => 2, 'sku' => 'sku2']);
        $item3->mapFromArray(['id' => 3, 'sku' => 'sku3']);

        $orderService = $this->container->get(OrderService::class);
        $order = $orderService->create();
        $order->setItems([$item1, $item2, $item3]);
        $this->assertSame($item2, $order->getItemById(2));
        $this->assertSame($item2, $order->getItemBySku('sku2'));
        $this->assertNull($order->getItemById(4));
        $this->assertNull($order->getItemBySku('sku4'));
    }

    public function testAddDeleteItem()
    {
        $orderItemService = $this->container->get(OrderItemService::class);
        $item1 = $orderItemService->create();
        $item2 = $orderItemService->create();
        $item3 = $orderItemService->create();
        $orderItemService->save($item1);
        $orderItemService->save($item2);
        $orderItemService->save($item3);

        $orderService = $this->container->get(OrderService::class);
        $order = $orderService->create();
        $order->setItems([$item1, $item2]);
        $order->addItem($item3);
        $order->deleteItem($item2);
        $orderService->save($order);

        $order = $orderService->findById($order->getId());
        $items = $order->getItems();
        $this->assertCount(2, $items);
        $this->assertEquals(1, $items[0]->getId());
        $this->assertEquals(3, $items[1]->getId());
    }

    public function testGetSetTotals()
    {
        $orderService = $this->container->get(OrderService::class);
        $order = $orderService->create();
        $this->assertEmpty($order->getTotals());
        $order->setTotals(['subtotal' => 110, 'total' => 100]);
        $this->assertEquals(['subtotal' => 110, 'total' => 100], $order->getTotals());
    }

    public function testSetItemsWithoutIdThrowsException()
    {
        $this->expectException(\RuntimeException::class);
        $orderItemService = $this->container->get(OrderItemService::class);
        $item = $orderItemService->create();
        $orderService = $this->container->get(OrderService::class);
        $order = $orderService->create();
        $order->setItems([$item]);
    }

    public function testAddItemWithoutIdThrowsException()
    {
        $this->expectException(\RuntimeException::class);
        $orderItemService = $this->container->get(OrderItemService::class);
        $item = $orderItemService->create();
        $orderService = $this->container->get(OrderService::class);
        $order = $orderService->create();
        $order->addItem($item);
    }
}
