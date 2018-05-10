<?php

namespace cubes\ecommerce\cart\tests;

use cubes\ecommerce\cart\CartHelper;
use cubes\ecommerce\cart\CartService;
use cubes\ecommerce\interfaces\ProductOfferInterface;
use cubes\ecommerce\product\ProductService;
use cubes\ecommerce\productOffer\ProductOfferItem;
use cubes\ecommerce\productOffer\ProductOfferItemService;
use cubes\system\auth\IdentityInterface;
use cubes\system\user\User;
use cubes\system\user\UserService;
use Mvkasatkin\mocker\Mocker;

class CartServiceTest extends \AppTestCase
{

    public function testCurrentEmptyAndNotLoggedUser()
    {
        $cartService = $this->container->get(CartService::class);
        $cartHelper = $this->container->get(CartHelper::class);

        $cart = $cartService->current();
        $this->assertNotEmpty($cart->getId());
        $this->assertNotEmpty($cartHelper->currentHash());
        $this->assertEquals('', $cart->user_id);
        $this->assertEquals($cartHelper->currentHash(), $cart->hash);
    }

    public function testCurrentEmptyAndLoggedUser()
    {
        $cartService = $this->container->get(CartService::class);
        $userService = $this->container->get(UserService::class);
        $user = $this->createUser();
        $userService->login($user);
        $this->assertNotEmpty($user->getId());

        $cart = $cartService->current();
        $this->assertNotEmpty($cart->getId());
        $this->assertEquals($user->getId(), $cart->user_id);
        $this->assertEquals('', $cart->hash);
    }

    public function testCurrentExistsAndNotLoggedUser()
    {
        $cartService = $this->container->get(CartService::class);
        $cart = $cartService->current();
        $this->assertNotEmpty($cart->hash);

        Mocker::setProperty($cartService, 'currentUserCart', null);
        $cart2 = $cartService->current();
        $this->assertEquals($cart->getId(), $cart2->getId());
        $this->assertEquals($cart->hash, $cart2->hash);
    }

    public function testCurrentExistsAndLoggedUser()
    {
        $cartService = $this->container->get(CartService::class);
        $userService = $this->container->get(UserService::class);
        $user = $this->createUser();
        $userService->login($user);

        $cart = $cartService->current();
        $this->assertEquals($user->getId(), $cart->user_id);

        Mocker::setProperty($cartService, 'currentUserCart', null);
        $cart2 = $cartService->current();
        $this->assertEquals($cart->getId(), $cart2->getId());
        $this->assertEquals($cart->user_id, $cart2->user_id);
    }

    public function testMerge()
    {
        // создать юзера
        $user = $this->createUser();

        // создать офферы и итемы
        $offers = $this->createOffers(5);

        // создать user cart с итемами
        $cartService = $this->container->get(CartService::class);
        $userCart = $cartService->create();
        $userCart->user_id = $user->getId();
        $userCart->addProductOffer($offers[0], 1);
        $userCart->addProductOffer($offers[1], 1);
        $userCart->addProductOffer($offers[2], 1);
        $cartService->save($userCart);

        // создать hash cart с итемами
        $cartHelper = $this->container->get(CartHelper::class);
        $hashCart = $cartService->create();
        $hashCart->hash = $cartHelper->currentHash();
        $hashCart->addProductOffer($offers[2], 2);
        $hashCart->addProductOffer($offers[3], 2);
        $hashCart->addProductOffer($offers[4], 2);
        $cartService->save($hashCart);

        // залогиниться
        $userService = $this->container->get(UserService::class);
        $userService->login($user);

        // получить корзину
        $cart = $cartService->current();

        // проверить итемы user cart
        $items = $cart->getItems();
        $this->assertCount(5, $items);
        $this->assertEquals('sku_1', $items[0]->getProductOffer()->getSku());
        $this->assertEquals('sku_2', $items[1]->getProductOffer()->getSku());
        $this->assertEquals('sku_3', $items[2]->getProductOffer()->getSku());
        $this->assertEquals('sku_4', $items[3]->getProductOffer()->getSku());
        $this->assertEquals('sku_5', $items[4]->getProductOffer()->getSku());
        $this->assertEquals(1, $items[0]->getQty());
        $this->assertEquals(1, $items[1]->getQty());
        $this->assertEquals(1, $items[2]->getQty());
        $this->assertEquals(2, $items[3]->getQty());
        $this->assertEquals(2, $items[4]->getQty());

        // проверить что удалена hash cart
        $hashCart = $cartService->findById($hashCart->getId());
        $this->assertNull($hashCart);
    }

    /**
     * @return IdentityInterface|User
     */
    private function createUser()
    {
        $userService = $this->container->get(UserService::class);
        /** @var IdentityInterface|User $user */
        $user = $userService->create();
        $userService->save($user);

        return $user;
    }

    /**
     * @param int $count
     *
     * @return ProductOfferInterface[]
     */
    private function createOffers(int $count = 5)
    {
        $result = [];
        $service = $this->container->get(ProductOfferItemService::class);
        for ($i = 1; $i <= $count; $i++) {
            /** @var ProductOfferItem $offerItem */
            $offerItem = $service->create();
            $offerItem->sku = 'sku_' . $i;
            $offerItem->name = 'name_' . $i;
            $offerItem->price = random_int(1000, 10000);
            $service->save($offerItem);
            $result[] = $offerItem;
        }

        return $result;
    }
}
