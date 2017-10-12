<?php

namespace WebComplete\mvc\front;

use WebComplete\core\utils\container\ContainerInterface;
use WebComplete\mvc\controller\AbstractController;
use WebComplete\mvc\router\Route;
use WebComplete\mvc\router\Router;
use WebComplete\mvc\router\exception\NotAllowedException;
use WebComplete\mvc\router\exception\NotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class FrontController
{
    const ERROR_CONTROLLER_KEY = 'errorController';

    public static $errorActions = [
        403 => 'action403',
        404 => 'action404',
        500 => 'action500',
    ];

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
     * @param ContainerInterface $controllerResolver
     */
    public function __construct(
        Router $router,
        Request $request,
        Response $response,
        ContainerInterface $controllerResolver
    ) {
        $this->router = $router;
        $this->request = $request;
        $this->response = $response;
        $this->controllerContainer = $controllerResolver;
    }

    /**
     * @param string|null $method
     * @param string|null $uri
     *
     * @return Response
     * @throws \UnexpectedValueException
     * @throws \InvalidArgumentException
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Exception
     */
    public function dispatch($method = null, $uri = null): Response
    {
        $method = $method ?? $this->request->getMethod();
        $uri = $uri ?? $this->request->getRequestUri();

        try {
            $route = $this->router->dispatch($method, $uri);
            $this->processRoute($route);
        } catch (NotFoundException $e) {
            $this->processError($e, 404);
        } catch (NotAllowedException $e) {
            $this->processError($e, 403);
        } catch (\Exception $e) {
            if (\ENV === 'dev') {
                throw $e;
            }
            $this->processError($e, 500);
        }
        $this->response->prepare($this->request);
        return $this->response;
    }

    /**
     * @param Route $route
     *
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function processRoute(Route $route)
    {
        $controllerClass = $route->getClass();
        $actionMethod = $route->getMethod();
        /** @var AbstractController $controller */
        $controller = $this->controllerContainer->get($controllerClass);
        $this->processController($controller, $actionMethod, $route->getParams());
    }

    /**
     * @param AbstractController $controller
     * @param string $actionMethod
     * @param array $params
     *
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     */
    public function processController(
        AbstractController $controller,
        string $actionMethod,
        array $params = []
    ) {
        $result = \call_user_func_array([$controller, $actionMethod], $params);
        $this->processResult($result);
    }

    /**
     * @param \Exception|null $exception
     * @param int $code
     *
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \UnexpectedValueException
     * @throws \InvalidArgumentException
     */
    public function processError(\Exception $exception = null, int $code)
    {
        $this->response->setContent('Page not found');
        if ($controller = $this->controllerContainer->get(self::ERROR_CONTROLLER_KEY)) {
            $this->processController($controller, self::$errorActions[$code], [$exception]);
        }
        $this->response->setStatusCode($code);
    }

    /**
     * @param $result
     *
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function processResult($result)
    {
        if (\is_string($result)) {
            $this->response->setStatusCode(200);
            $this->response->headers->set('content-type', 'text/html');
            $this->response->setContent($result);
        } elseif (\is_array($result)) {
            $this->response->setStatusCode(200);
            $this->response->headers->set('content-type', 'application/json');
            $this->response->setContent(\json_encode($result));
        } elseif ($result instanceof Response) {
            if ($result instanceof RedirectResponse) {
                $this->response = $result;
            } elseif ($result->getStatusCode() !== 200) {
                $this->processError(null, $result->getStatusCode());
            }
        }
    }
}
