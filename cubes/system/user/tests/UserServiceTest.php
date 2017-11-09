<?php

namespace cubes\system\user\tests;

use cubes\system\user\User;
use cubes\system\user\UserService;

class UserServiceTest extends \AppTestCase
{

    public function testUserCanLogin()
    {
        $userService = $this->container->get(UserService::class);
        $this->assertNull($userService->current());
        /** @var User $user */
        $user = $userService->create();
        $user->setId(1);
        $userService->login($user);
        $this->assertSame($user, $userService->current());
    }

    public function testUserCanLogout()
    {
        $userService = $this->container->get(UserService::class);
        /** @var User $user */
        $user = $userService->create();
        $user->setId(1);
        $userService->login($user);
        $this->assertSame($user, $userService->current());
        $userService->logout();
        $this->assertNull($userService->current());
    }

    public function testFindByToken()
    {
        $userService = $this->container->get(UserService::class);
        /** @var User $user */
        $user = $userService->create();
        $user->setToken('1234567');
        $userService->save($user);
        $user1 = $userService->findByToken('12345678');
        $this->assertNull($user1);
        $user2 = $userService->findByToken('1234567');
        $this->assertNotNull($user2);
        $this->assertEquals($user->getId(), $user2->getId());
    }
}
