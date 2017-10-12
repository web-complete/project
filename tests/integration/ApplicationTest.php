<?php

namespace tests\integration;

use Mvkasatkin\mocker\Mocker;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use tests\ThunderTestCase;
use WebComplete\core\utils\container\ContainerInterface;
use WebComplete\mvc\Application;
use WebComplete\mvc\front\FrontController;
use WebComplete\mvc\router\exception\Exception;

class ApplicationTest extends ThunderTestCase
{

    public function testCreateApplication()
    {
        $application = $this->createApplication();
        $this->assertInstanceOf(Application::class, $application);
        return $application;
    }

    public function testHtmlString()
    {
        $application = $this->createApplication();
        $front = $application->getContainer()->make(FrontController::class);
        $response = $front->dispatch('GET', '/some/string');
        $this->assertEquals('index string', $response->getContent());
        $this->assertContains('text/html', $response->headers->get('content-type'));
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testHtmlResponseWithLayout()
    {
        $application = $this->createApplication();
        $front = $application->getContainer()->make(FrontController::class);
        $response = $front->dispatch('GET', '/some/layout');
        $this->assertContains('text/html', $response->headers->get('content-type'));
        $this->assertEquals('<div>header</div>content<div>footer</div>', $response->getContent());
    }

    public function testHtmlResponseWithPartial()
    {
        $application = $this->createApplication();
        $front = $application->getContainer()->make(FrontController::class);
        $response = $front->dispatch('GET', '/some/partial');
        $this->assertContains('text/html', $response->headers->get('content-type'));
        $this->assertEquals('partial', $response->getContent());
    }

    public function testJsonResponse()
    {
        $application = $this->createApplication();
        $front = $application->getContainer()->make(FrontController::class);
        $response = $front->dispatch('GET', '/some/json');
        $this->assertEquals('application/json', $response->headers->get('content-type'));
        $this->assertEquals('{"a":"b"}', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testArrayResponse()
    {
        $application = $this->createApplication();
        $front = $application->getContainer()->make(FrontController::class);
        $response = $front->dispatch('GET', '/some/array');
        $this->assertEquals('application/json', $response->headers->get('content-type'));
        $this->assertEquals('{"a":"b"}', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testRedirectResponse()
    {
        $application = $this->createApplication();
        $front = $application->getContainer()->make(FrontController::class);
        /** @var RedirectResponse $response */
        $response = $front->dispatch('GET', '/some/redirect');
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('url2', $response->getTargetUrl());
        $this->assertEquals(301, $response->getStatusCode());
    }

    public function testRouteNotFound()
    {
        $application = $this->createApplication();
        $front = $application->getContainer()->make(FrontController::class);
        $response = $front->dispatch('GET', '/some/not-exists');
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('error 404', $response->getContent());
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testContentNotFound()
    {
        $application = $this->createApplication();
        $front = $application->getContainer()->make(FrontController::class);
        $response = $front->dispatch('GET', '/some/not-found');
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('error 404', $response->getContent());
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testAccessDenied()
    {
        $application = $this->createApplication();
        $front = $application->getContainer()->make(FrontController::class);
        $response = $front->dispatch('GET', '/some/access-denied');
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('error 403', $response->getContent());
        $this->assertEquals(403, $response->getStatusCode());
    }

    public function testSystemError()
    {
        $application = $this->createApplication();
        $front = $application->getContainer()->make(FrontController::class);
        $response = $front->dispatch('GET', '/some/system-error');
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('error 500', $response->getContent());
        $this->assertEquals(500, $response->getStatusCode());
    }

    public function testOnlyPost()
    {
        $application = $this->createApplication();
        $front = $application->getContainer()->get(FrontController::class);
        $response = $front->dispatch('GET', '/some/only-post');
        $this->assertEquals('error 403', $response->getContent());
        $this->assertEquals(403, $response->getStatusCode());
        $response = $front->dispatch('POST', '/some/only-post');
        $this->assertEquals('only post', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testVars()
    {
        $application = $this->createApplication();
        $front = $application->getContainer()->make(FrontController::class);
        $response = $front->dispatch('GET', '/some/vars');
        $this->assertEquals('ab', $response->getContent());
    }

    public function testRouterInvalidController()
    {
        $application = $this->createApplication();
        $front = $application->getContainer()->make(FrontController::class);
        $response = $front->dispatch('GET', '/some/fail1');
        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals('error 500', $response->getContent());
    }

    public function testRouterInvalidAction()
    {
        $application = $this->createApplication();
        $front = $application->getContainer()->make(FrontController::class);
        $response = $front->dispatch('GET', '/some/fail2');
        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals('error 500', $response->getContent());
    }

    public function testContainer()
    {
        $application = $this->createApplication();
        /** @var ContainerInterface $container */
        $container = Mocker::create(ContainerInterface::class);
        $application->setContainer($container);
        $this->assertSame($container, $application->getContainer());
    }

    /**
     * @return Application
     */
    protected function createApplication(): Application
    {
        \defined('ENV') or \define('ENV', 'prod');
        $config = require __DIR__ . '/../include/app/config/config.php';
        return new Application($config);
    }

    // todo route exception controller name
    // todo route exception action name
}
