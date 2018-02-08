# Набор кубов для E-commerce

Нэймспэйс **ecommerce** включает в себя следующие кубы:
- product
- cart
- cartItem
- checkout
- order
- orderItem

а также набор интерфейсов **interfaces**:
- ProductOfferInterface
- ProductOfferServiceInterface
- CartInterface
- CartItemInterface
- CartServiceInterface
- CheckoutInterface
- OrderInterface
- OrderItemInterface
- OrderServiceInterface

Пример программного создания заказа:
```php
        // создать товары
        $productService = $this->container->get(ProductService::class);
        $product1 = $productService->create();
        $product2 = $productService->create();
        $product3 = $productService->create();
        $productService->save($product1);
        $productService->save($product2);
        $productService->save($product3);

        // получить корзину текущего пользователя
        $cartService = $this->container->get(CartService::class);
        $cart = $cartService->current();
        
        // добавить товары в корзину
        $cart->addProductOffer($product1);
        $cart->addProductOffer($product2);
        $cart->addProductOffer($product3);
        
        // смета корзины расчитывается необходимым для проекта способом
        $cart->setTotals($totals);
        
        // сохранить корзину
        $cartService->save($cart);

        // создать чекаут (получить текущий)
        $checkout = $cart->getCheckout();
        $checkout->first_name = 'FirstName1';
        $checkout->last_name = 'LastName1';
        $checkout->email = 'email1@example.com';

        // создать заказ на основании корзины
        $orderService = $this->container->get(OrderService::class);
        $order = $orderService->createOrder($cart);
        
        // данные заказа
        $orderItems = $order->getItems();
        $orderTotals = $order->getTotals();
        $orderCheckout = $order->getCheckout();
```
