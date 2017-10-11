<?php

namespace tests\integration;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use tests\ThunderTestCase;
use WebComplete\thunder\Application;
use WebComplete\thunder\front\FrontController;

class ApplicationTest extends ThunderTestCase
{

    /**
     */
    public function testCreateApplication()
    {
        \defined('ENV')
        or \define('ENV', 'prod');
        $application = $this->createApplication();
        $this->assertInstanceOf(Application::class, $application);
    }

    /**
     */
    public function testDispatchController()
    {
        $application = $this->createApplication();
        $front = $application->getContainer()->get(FrontController::class);
        $response = $front->dispatch('GET', '/some/index');
        $this->assertEquals('index string', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     */
    public function testHtmlResponseWithLayout()
    {
        $application = $this->createApplication();
        $front = $application->getContainer()->get(FrontController::class);
        $response = $front->dispatch('GET', '/some/layout');
        $this->assertEquals('<div>header</div>content<div>footer</div>', $response->getContent());
    }

    /**
     */
    public function testHtmlResponseWithPartial()
    {
        $application = $this->createApplication();
        $front = $application->getContainer()->get(FrontController::class);
        $response = $front->dispatch('GET', '/some/partial');
        $this->assertEquals('partial', $response->getContent());
    }

    /**
     */
    public function testJsonResponse()
    {
        $application = $this->createApplication();
        $front = $application->getContainer()->get(FrontController::class);
        $response = $front->dispatch('GET', '/some/json');
        $this->assertEquals('{"a":"b"}', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     */
    public function testRedirectResponse()
    {
        $application = $this->createApplication();
        $front = $application->getContainer()->get(FrontController::class);
        /** @var RedirectResponse $response */
        $response = $front->dispatch('GET', '/some/redirect');
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('url2', $response->getTargetUrl());
        $this->assertEquals(301, $response->getStatusCode());
    }

    /**
     */
    public function testRouteNotFound()
    {
        $application = $this->createApplication();
        $front = $application->getContainer()->get(FrontController::class);
        $response = $front->dispatch('GET', '/some/not-exists');
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('error 404', $response->getContent());
        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     */
    public function testContentNotFound()
    {
        $application = $this->createApplication();
        $front = $application->getContainer()->get(FrontController::class);
        $response = $front->dispatch('GET', '/some/not-found');
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('error 404', $response->getContent());
        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     */
    public function testAccessDenied()
    {
        $application = $this->createApplication();
        $front = $application->getContainer()->get(FrontController::class);
        $response = $front->dispatch('GET', '/some/access-denied');
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('error 403', $response->getContent());
        $this->assertEquals(403, $response->getStatusCode());
    }

    /**
     */
    public function testSystemError()
    {
        $application = $this->createApplication();
        $front = $application->getContainer()->get(FrontController::class);
        $response = $front->dispatch('GET', '/some/system-error');
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('error 500', $response->getContent());
        $this->assertEquals(500, $response->getStatusCode());
    }

    /**
     */
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

    // TODO test post request
    // TODO test post/get/files/headers in controller + view vars + get controller in layout

    /**
     * @return Application
     */
    protected function createApplication(): Application
    {
        $config = require __DIR__ . '/../include/app/config/config.php';
        return new Application($config);
    }
}
