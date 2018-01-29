<?php

namespace cubes\system\elastic;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class ElasticSearch
{
    /**
     * @var bool
     */
    public $safe;
    /**
     * @var string
     */
    protected $prefix;
    /**
     * @var string[]
     */
    protected $hosts;
    /**
     * @var Client
     */
    protected $client;

    /**
     * @param string $prefix
     * @param string[] $hosts
     * @param bool $safe
     */
    public function __construct(string $prefix, array $hosts, bool $safe = true)
    {
        $this->prefix = $prefix;
        $this->hosts = $hosts;
        $this->safe = $safe;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        if (!$this->client) {
            $this->client = ClientBuilder::create()->setHosts($this->hosts)->build();
        }
        return $this->client;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public function getIndexName(string $name): string
    {
        return $this->prefix . ':' . $name;
    }
}
