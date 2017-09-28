<?php

namespace WebComplete\thunder\front;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\core\utils\container\ContainerInterface;
use WebComplete\thunder\router\Route;
use WebComplete\thunder\router\Router;
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
     * @var ContainerInterface
     */
    private $controllerContainer;

    /**
     * @param Router $router
     * @param Request $request
     * @param Response $response
     * @param ContainerInterface $controllerContainer
     */
    public function __construct(
        Router $router,
        Request $request,
        Response $response,
        ContainerInterface $controllerContainer
    ) {
        $this->router = $router;
        $this->request = $request;
        $this->response = $response;
        $this->controllerContainer = $controllerContainer;
    }

    /**
     * @return Response
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function dispatch(): Response
    {
        $method = $this->request->getMethod();
        $uri = $this->request->getPathInfo();

        try {
            $route = $this->router->dispatch($method, $uri);
            return $this->processRoute($route);
        } catch (NotFoundException $e) {
            return $this->process404($e);
        } catch (NotAllowedException $e) {
            return $this->process403($e);
        } catch (\Exception $e) {
            if (\ENV === 'prod') {
                return $this->process500();
            }
            throw $e;
        }
    }

    /**
     * @param Route $route
     *
     * @return Response
     * @throws \UnexpectedValueException
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function processRoute(Route $route): Response
    {
        $controllerClass = $route->getClass();
        $actionMethod = $route->getMethod();
        $controller = $this->controllerContainer->get($controllerClass);
        $result = \call_user_func_array([$controller, $actionMethod], $route->getParams());
        $this->response->setContent($result);
        return $this->response;
    }

    /**
     * @param Exception|null $e
     *
     * @return Response
     */
    public function process404(Exception $e = null): Response
    {
        // TODO customizable
        return $this->response;
    }

    /**
     * @param Exception|null $e
     *
     * @return Response
     */
    public function process403(Exception $e = null): Response
    {
        // TODO customizable
        return $this->response;
    }

    /**
     * @param Exception|null $e
     *
     * @return Response
     */
    public function process500(Exception $e = null): Response
    {
        // TODO customizable
        return $this->response;
    }
}
