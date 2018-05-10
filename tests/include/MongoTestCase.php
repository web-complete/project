<?php

use cubes\system\mongo\Mongo;
use MongoDB\Client;

class MongoTestCase extends AppTestCase
{
    /** @var Mongo */
    protected $mongo;

    public function setUp()
    {
        parent::setUp();
        $this->mongo = $this->container->get(Mongo::class);
        $this->mongo->getDatabase()->drop();
    }

    /**
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function tearDown()
    {
        parent::tearDown();
        $this->mongo->getDatabase()->drop();
    }

}
