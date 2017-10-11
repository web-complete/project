<?php

namespace tests\integration;

use Symfony\Component\HttpFoundation\RedirectResponse;
use tests\ThunderTestCase;
use WebComplete\thunder\Application;
use WebComplete\thunder\front\FrontController;

class ApplicationTest extends ThunderTestCase
{

    /**
     * @return Application
     */
    public function testCreateApplication(): \WebComplete\thunder\Application
    {
        defined('ENV')
        or define('ENV', 'prod');

        $config = require __DIR__ . '/../include/app/config/config.php';
        $application = new \WebComplete\thunder\Application($config);
        $this->assertInstanceOf(Application::class, $application);
        return $application;
    }

    /**
     * @depends testCreateApplication
     * @param Application $application
     */
    public function testDispatchController(Application $application)
    {
        $front = $application->getContainer()->get(FrontController::class);
        $response = $front->dispatch('GET', '/some/index');
        $this->assertEquals('index string', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @depends testCreateApplication
     * @param Application $application
     */
    public function testHtmlResponseWithLayout(Application $application)
    {
        $front = $application->getContainer()->get(FrontController::class);
        $response = $front->dispatch('GET', '/some/layout');
        $this->assertEquals('<div>header</div>content<div>footer</div>', $response->getContent());
    }

    /**
     * @depends testCreateApplication
     * @param Application $application
     */
    public function testHtmlResponseWithPartial(Application $application)
    {
        $front = $application->getContainer()->get(FrontController::class);
        $response = $front->dispatch('GET', '/some/partial');
        $this->assertEquals('partial', $response->getContent());
    }

    /**
     * @depends testCreateApplication
     * @param Application $application
     */
    public function testJsonResponse(Application $application)
    {
        $front = $application->getContainer()->get(FrontController::class);
        $response = $front->dispatch('GET', '/some/json');
        $this->assertEquals('{"a":"b"}', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @depends testCreateApplication
     * @param Application $application
     */
    public function testRedirectResponse(Application $application)
    {
        $front = $application->getContainer()->get(FrontController::class);
        /** @var RedirectResponse $response */
        $response = $front->dispatch('GET', '/some/redirect');
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('url2', $response->getTargetUrl());
        $this->assertEquals(301, $response->getStatusCode());
    }

    /**
     * @depends testCreateApplication
     * @param Application $application
     */
    public function testRouteNotFound(Application $application)
    {
        $front = $application->getContainer()->get(FrontController::class);
        $response = $front->dispatch('GET', '/some/not-exists');
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('error 404', $response->getContent());
        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * @depends testCreateApplication
     * @param Application $application
     */
    public function testContentNotFound(Application $application)
    {
        $front = $application->getContainer()->get(FrontController::class);
        $response = $front->dispatch('GET', '/some/not-found');
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('error 404', $response->getContent());
        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * @depends testCreateApplication
     * @param Application $application
     */
    public function testAccessDenied(Application $application)
    {
        $front = $application->getContainer()->get(FrontController::class);
        $response = $front->dispatch('GET', '/some/access-denied');
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('error 403', $response->getContent());
        $this->assertEquals(403, $response->getStatusCode());
    }

    /**
     * @depends testCreateApplication
     * @param Application $application
     */
    public function testSystemError(Application $application)
    {
        $front = $application->getContainer()->get(FrontController::class);
        $response = $front->dispatch('GET', '/some/system-error');
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('error 500', $response->getContent());
        $this->assertEquals(500, $response->getStatusCode());
    }

    // TODO test post request
    // TODO test post/get/files/headers in controller + view vars + get controller in layout
}
