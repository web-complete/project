<?php

namespace modules\admin\classes\csrf;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use WebComplete\mvc\router\exception\NotAllowedException;

class CSRF
{
    const KEY_SET = '_csrf';
    const KEY_GET = '_csrf_check';

    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Response
     */
    protected $response;
    /**
     * @var Session
     */
    protected $session;
    /**
     * @var string
     */
    protected $token;

    /**
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
        $this->session = $request->getSession();
    }

    /**
     * @throws \InvalidArgumentException
     * @throws NotAllowedException
     */
    public function process()
    {
        $storedTokens = (array)$this->session->get(self::KEY_SET, []);
        $currentToken = $this->request->cookies->get(self::KEY_GET);

        if ($this->request->getMethod() !== 'GET') {
            if ($storedTokens && !\in_array($currentToken, $storedTokens, true)) {
                throw new NotAllowedException('CSRF protection');
            }
        }

        $this->token = $this->generateToken();
        $storedTokens[] = $this->token;
        $storedTokens = \array_slice($storedTokens, -3);
        $this->session->set(self::KEY_SET, $storedTokens);
        $cookie = new Cookie(self::KEY_SET, $this->token, 0, '/', null, false, false, false, Cookie::SAMESITE_STRICT);
        $this->response->headers->setCookie($cookie);
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return string
     */
    protected function generateToken(): string
    {
        return md5(microtime() . random_int(1, 1000000));
    }
}
