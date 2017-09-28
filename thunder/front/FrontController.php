<?php

namespace WebComplete\thunder\front;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\thunder\Route;
use WebComplete\thunder\Router;
use WebComplete\thunder\router\exception\Exception;
use WebComplete\thunder\router\exception\NotAllowedException;
use WebComplete\thunder\router\exception\NotFoundException;

class FrontController
{

    /**
     * @var Request
     */
    private $request;
    /**
     * @var Response
     */
    private $response;
    /**
     * @var Router
     */
    private $router;

    /**
     * @param Request $request
     * @param Response $response
     * @param Router $router
     */
    public function __construct(Request $request, Response $response, Router $router)
    {
        $this->request = $request;
        $this->response = $response;
        $this->router = $router;
    }

    /**
     */
    public function dispatch()
    {
        try {
            $route = $this->router->dispatch($this->request->getMethod(), $this->request->getPathInfo());
            $this->processRoute($route);
        } catch (NotFoundException $e) {
            $this->process404($e);
        } catch (NotAllowedException $e) {
            $this->process403($e);
        }
    }

    public function processRoute(Route $route)
    {
        $controllerClass = $route->getClass();
        $actionMethod = $route->getMethod();
        if (class_exists($controllerClass)) {
        }
    }

    /**
     * @param Exception $e
     */
    protected function process404(Exception $e)
    {
        // TODO customizable
    }

    /**
     * @param Exception $e
     */
    protected function process403(Exception $e)
    {
        // TODO customizable
    }
}
