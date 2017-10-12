<?php

namespace tests\unit\front;

use Mvkasatkin\mocker\Mocker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use tests\ThunderTestCase;
use WebComplete\core\utils\container\ContainerInterface;
use WebComplete\mvc\controller\AbstractController;
use WebComplete\mvc\front\FrontController;
use WebComplete\mvc\router\Route;
use WebComplete\mvc\router\Router;

class FrontControllerTest extends ThunderTestCase
{

    public function testDispatch()
    {
        $route = new Route('class1', 'method1', []);
        /** @var Router $router */
        $router = Mocker::create(Router::class, [
            Mocker::method('dispatch', 1)->with(['POST', 'uri1'])->returns($route)
        ]);
        $request = new Request();
        $request->setMethod('POST');
        Mocker::setProperty($request, 'requestUri', 'uri1');
        $response = new Response();
        /** @var ContainerInterface $container */
        $container = Mocker::create(ContainerInterface::class);
        /** @var FrontController $front */
        $front = Mocker::create(FrontController::class, [
            Mocker::method('processRoute', 1)->with([$route])->returns($response)
        ], [$router, $request, $response, $container]);
        $front->dispatch();
    }

    public function testProcessRoute()
    {
        $controller = Mocker::create(AbstractController::class);
        $route = new Route('class1', 'method1', ['a', 'b']);
        /** @var Router $router */
        $router = Mocker::create(Router::class);
        $request = new Request();
        $response = new Response();
        /** @var ContainerInterface $container */
        $container = Mocker::create(ContainerInterface::class, [
            Mocker::method('get', 1)->with(['class1'])->returns($controller)
        ]);
        /** @var FrontController $front */
        $front = Mocker::create(FrontController::class, [
            Mocker::method('processController', 1)->with([$controller, 'method1', ['a', 'b']])->returns($response)
        ], [$router, $request, $response, $container]);
        $front->processRoute($route);
    }

    public function testProcessController()
    {
        /** @var AbstractController $controller */
        $controller = Mocker::create(AbstractController::class, [
            Mocker::method('some', 1)->with(['a'])->returns('aaa')
        ]);
        /** @var Router $router */
        $router = Mocker::create(Router::class);
        $request = new Request();
        $response = new Response();
        /** @var ContainerInterface $container */
        $container = Mocker::create(ContainerInterface::class);
        /** @var FrontController $front */
        $front = Mocker::create(FrontController::class, [
            Mocker::method('processResult', 1)->with(['aaa'])
        ], [$router, $request, $response, $container]);
        $front->processController($controller, 'some', ['a']);
    }

    public function testProcessError()
    {
        $exception = new \Exception();
        $controller = Mocker::create(AbstractController::class);
        /** @var Router $router */
        $router = Mocker::create(Router::class);
        $request = new Request();
        $response = new Response();
        /** @var ContainerInterface $container */
        $container = Mocker::create(ContainerInterface::class, [
            Mocker::method('get', 1)->with([FrontController::ERROR_CONTROLLER_KEY])->returns($controller)
        ]);
        /** @var FrontController $front */
        $front = Mocker::create(FrontController::class, [
            Mocker::method('processController', 1)
                ->with([$controller, FrontController::$errorActions[403], [$exception]])->returns($response)
        ], [$router, $request, $response, $container]);
        $front->processError($exception, 403);
    }
}
