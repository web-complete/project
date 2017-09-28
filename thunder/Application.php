<?php

namespace WebComplete\thunder;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Application
{

    /** @var Request */
    protected $request;

    /** @var Response */
    protected $response;

    /**
     * @param Request|null $request
     * @param Response|null $response
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(Request $request = null, Response $response = null)
    {
        $this->request = $request ?? Request::createFromGlobals();
        $this->response = $response ?? new Response();
    }

    public function run()
    {
    }


}
