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
        $this->initApplication();
        $this->db->beginTransaction();
        \WebComplete\microDb\StorageRuntime::clear();
    }

    /**
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function tearDown()
    {
        $this->db->rollBack();
        parent::tearDown();
    }

    private function initApplication()
    {
        global $config;
        global $application;
        $application = new \modules\Application($config, false);
        $microDb = $application->getContainer()->get(\WebComplete\microDb\MicroDb::class);
        $microDb->setType('runtime');

        $this->container = $application->getContainer();
        $this->config = $this->container->get(ApplicationConfig::class);
        $this->db = $this->container->get(Connection::class); // original db instance
    }
}
