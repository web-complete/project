<?php

use Doctrine\DBAL\Connection;
use Mvkasatkin\mocker\Mocker;
use WebComplete\core\utils\container\ContainerInterface;
use WebComplete\mvc\ApplicationConfig;

class AppTestCase extends \PHPUnit\Framework\TestCase
{

    /** @var ContainerInterface */
    protected $container;
    /** @var Connection */
    protected $db;
    /** @var ApplicationConfig */
    protected $config;

    public function setUp()
    {
        parent::setUp();
        Mocker::init($this);
        $this->cloneContainer();
        $this->db->beginTransaction();
        $this->config = $this->container->get(ApplicationConfig::class);
    }

    public function tearDown()
    {
        $this->db->rollBack();
        parent::tearDown();
    }

    private function cloneContainer()
    {
        global $application;
        $containerAdapter = $application->getContainer();
        $this->db = $containerAdapter->get(Connection::class); // original db instance
        $container = Mocker::getProperty($containerAdapter, 'container');
        $this->container = new \WebComplete\core\utils\container\ContainerAdapter(clone $container);
    }
}
