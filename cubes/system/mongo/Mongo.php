<?php

namespace cubes\system\mongo;

use MongoDB\Client;
use MongoDB\Database;

class Mongo
{
    /**
     * @var Client
     */
    protected $client;
    /**
     * @var Database
     */
    protected $database;
    /**
     * @var MongoSequence
     */
    protected $sequence;

    /**
     * @param Client $client
     * @param string $database
     */
    public function __construct(Client $client, $database)
    {
        $this->client = $client;
        $this->database = $client->selectDatabase($database);
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @param $name
     * @return \MongoDB\Collection
     */
    public function selectCollection($name): \MongoDB\Collection
    {
        return $this->getClient()->selectCollection($this->database->getDatabaseName(), $name);
    }

    /**
     * @return Database
     */
    public function getDatabase(): Database
    {
        return $this->database;
    }

    /**
     * @return MongoSequence
     */
    public function getSequence(): MongoSequence
    {
        if (!$this->sequence) {
            $this->sequence = new MongoSequence($this);
        }
        return $this->sequence;
    }
}
