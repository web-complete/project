<?php

namespace cubes\system\elastic;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class ElasticSearchDriver
{
    /**
     * @var bool
     */
    public $debug;
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
    protected $lastSearchQuery = '';

    /**
     * @param string $prefix
     * @param string[] $hosts
     * @param bool $debug
     */
    public function __construct(string $prefix, array $hosts, bool $debug = false)
    {
        $this->prefix = $prefix;
        $this->hosts = $hosts;
        $this->debug = $debug;
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

    /**
     * @param array $params
     */
    public function setLastSearchQuery(array $params)
    {
        $this->lastSearchQuery = $this->debug
            ? \json_encode($params, \JSON_PRETTY_PRINT)
            : \json_encode($params);
    }

    /**
     * @return string
     */
    public function getLastSearchQuery(): string
    {
        return $this->lastSearchQuery;
    }
}
