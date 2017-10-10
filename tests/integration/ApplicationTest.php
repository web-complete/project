<?php

namespace tests\integration;

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
        or define('ENV', in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'], false) ? 'dev' : 'prod');

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
    }

    // TODO test html response with layout
    // TODO test html response with partial
    // TODO test json response
    // TODO test redirect response
    // TODO test 404
    // TODO test 403
    // TODO test 500
}
