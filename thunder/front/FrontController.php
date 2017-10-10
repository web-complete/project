<?php

namespace WebComplete\thunder\front;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\core\utils\container\ContainerInterface;
use WebComplete\thunder\controller\AbstractController;
use WebComplete\thunder\controller\response\ControllerResponseInterface;
use WebComplete\thunder\controller\response\ResponseHtml;
use WebComplete\thunder\controller\response\ResponseJson;
use WebComplete\thunder\controller\response\ResponseRedirect;
use WebComplete\thunder\router\Route;
use WebComplete\thunder\router\Router;
use WebComplete\thunder\router\exception\NotAllowedException;
use WebComplete\thunder\router\exception\NotFoundException;

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
            return $this->processRoute($route);
        } catch (NotFoundException $e) {
            return $this->processError($e, 404);
        } catch (NotAllowedException $e) {
            return $this->processError($e, 403);
        } catch (\Exception $e) {
            if (\ENV === 'prod') {
                return $this->processError($e, 500);
            }
            throw $e;
        }
    }

    /**
     * @param Route $route
     *
     * @return Response
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function processRoute(Route $route): Response
    {
        $controllerClass = $route->getClass();
        $actionMethod = $route->getMethod();
        $controller = $this->controllerContainer->get($controllerClass);
        $this->processController($controller, $actionMethod, $route->getParams());
        return $this->response;
    }

    /**
     * @param AbstractController $controller
     * @param string $actionMethod
     * @param array $params
     *
     * @return Response
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     */
    public function processController(
        AbstractController $controller,
        string $actionMethod,
        array $params = []
    ): Response {
        $result = \call_user_func_array([$controller, $actionMethod], $params);
        $this->processResult($result);
        return $this->response;
    }

    /**
     * @param \Exception|null $exception
     * @param int $code
     *
     * @return Response
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \UnexpectedValueException
     * @throws \InvalidArgumentException
     */
    public function processError(\Exception $exception = null, int $code): Response
    {
        $this->response->setStatusCode($code);
        if ($controller = $this->controllerContainer->get(self::ERROR_CONTROLLER_KEY)) {
            return $this->processController($controller, self::$errorActions[$code], [$exception]);
        }
        $this->response->setContent('Page not found');
        return $this->response;
    }

    /**
     * @param $result
     *
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     */
    protected function processResult($result)
    {
        if (\is_string($result)) {
            $this->response->headers->set('content-type', 'text/html');
            $this->response->setContent($result);
        } elseif ($result instanceof ControllerResponseInterface) {
            if ($result instanceof ResponseHtml) {
                $this->response->headers->set('content-type', 'text/html');
                $this->response->setContent($result->getContent());
            }
            if ($result instanceof ResponseJson) {
                $this->response->headers->set('content-type', 'application/json');
                $this->response->setContent(\json_encode($result->getContent()));
            }
            if ($result instanceof ResponseRedirect) {
                $this->response = $this->createRedirectResponse(
                    $result->getUrl(),
                    $result->getCode(),
                    $result->getHeaders()
                );
            }
        }
    }

    /**
     * @param string $url
     * @param int $code
     * @param array $headers
     *
     * @return RedirectResponse
     * @throws \InvalidArgumentException
     */
    protected function createRedirectResponse(string $url, int $code, array $headers = []): RedirectResponse
    {
        return new RedirectResponse($url, $code, $headers);
    }
}
