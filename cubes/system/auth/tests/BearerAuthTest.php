<?php

namespace cubes\system\auth\tests;

use cubes\system\auth\BearerAuth;
use cubes\system\auth\IdentityServiceInterface;
use cubes\system\user\User;
use Mvkasatkin\mocker\Mocker;
use Symfony\Component\HttpFoundation\Request;

class BearerAuthTest extends \AppTestCase
{

    public function testAuthOk()
    {
        $user = Mocker::create(User::class);
        $request = new Request();
        $request->headers->set('Authorization', 'Bearer some_token1');
        /** @var IdentityServiceInterface $identityService */
        $identityService = Mocker::create(IdentityServiceInterface::class, [
            Mocker::method('findByToken', 1, 'some_token1')->returns($user),
            Mocker::method('login', 1, $user)
        ]);
        $auth = new BearerAuth($request, $identityService);
        $this->assertTrue($auth->authenticate());
    }

    public function testAuthFailUserNotFound()
    {
        $request = new Request();
        $request->headers->set('Authorization', 'Bearer some_token1');
        /** @var IdentityServiceInterface $identityService */
        $identityService = Mocker::create(IdentityServiceInterface::class, [
            Mocker::method('findByToken', 1, 'some_token1')->returns(null),
            Mocker::method('login', 0)
        ]);
        $auth = new BearerAuth($request, $identityService);
        $this->assertFalse($auth->authenticate());
    }

    public function testAuthFailNoHeader()
    {
        $request = new Request();
        $request->headers->set('Authorization', 'Bearer_some_token_wrong_header');
        /** @var IdentityServiceInterface $identityService */
        $identityService = Mocker::create(IdentityServiceInterface::class, [
            Mocker::method('findByToken', 0),
            Mocker::method('login', 0)
        ]);
        $auth = new BearerAuth($request, $identityService);
        $this->assertFalse($auth->authenticate());
    }
}