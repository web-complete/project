<?php

namespace cubes\ecommerce\cart;

use cubes\system\user\UserService;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CartHelper
{
    const COOKIE_NAME = 'cart_hash';

    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var Request
     */
    private $request;
    /**
     * @var Response
     */
    private $response;

    /**
     * @param UserService $userService
     * @param Request $request
     * @param Response $response
     */
    public function __construct(UserService $userService, Request $request, Response $response)
    {
        $this->userService = $userService;
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return int|null|string
     */
    public function currentUserId()
    {
        if ($user = $this->userService->current()) {
            return $user->getId();
        }
        return null;
    }

    /**
     * @return string
     */
    public function currentHash(): string
    {
        if ($this->request && $this->response) {
            if (!$hash = $this->request->cookies->get(self::COOKIE_NAME)) {
                $hash = $this->generateHash();
                $this->request->cookies->set(self::COOKIE_NAME, $hash);
                $this->response->headers->setCookie(new Cookie(self::COOKIE_NAME, $hash));
            }
        } else {
            $hash = $this->generateHash();
        }
        return $hash;
    }

    /**
     * @return string
     */
    protected function generateHash(): string
    {
        return \md5(\microtime(true) . \random_int(1, 1000000));
    }
}
