<?php

use Mvkasatkin\mocker\Mocker;
use WebComplete\core\utils\container\ContainerInterface;

class AppTestCase extends \PHPUnit\Framework\TestCase
{

    /** @var ContainerInterface */
    protected $container;

    public function setUp()
    {
        parent::setUp();
        Mocker::init($this);
        $this->cloneContainer();
    }

    private function cloneContainer()
    {
        global $application;
        $containerAdapter = $application->getContainer();
        $container = Mocker::getProperty($containerAdapter, 'container');
        $this->container = new \WebComplete\core\utils\container\ContainerAdapter(clone $container);
    }
}
