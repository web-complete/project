<?php

namespace cubes\system\auth;

use Symfony\Component\HttpFoundation\Request;

class BearerAuth
{

    /**
     * @var Request
     */
    protected $request;
    /**
     * @var IdentityServiceInterface
     */
    protected $identityService;

    /**
     * @param Request $request
     * @param IdentityServiceInterface $identityService
     */
    public function __construct(Request $request, IdentityServiceInterface $identityService)
    {
        $this->request = $request;
        $this->identityService = $identityService;
    }

    /**
     * @return bool
     */
    public function authenticate(): bool
    {
        $authHeader = $this->request->headers->get('Authorization');
        if ($authHeader !== null && \preg_match('/^Bearer\s+(.*?)$/', $authHeader, $matches)) {
            $token = $matches[1];
            if ($identity = $this->identityService->findByToken($token)) {
                $this->identityService->login($identity);
                return true;
            }
        }

        return false;
    }
}
