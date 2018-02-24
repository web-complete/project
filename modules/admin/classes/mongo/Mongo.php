<?php

namespace modules\admin\classes\mongo;

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
