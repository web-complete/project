<?php

namespace cubes\system\elastic;

use cubes\system\logger\Log;

abstract class AbstractElasticIndex
{

    /**
     * @var ElasticSearchDriver
     */
    protected $elasticSearch;
    protected $defaultType = 'main';
    protected $refresh = false; // true | wait_for

    /**
     * @param ElasticSearchDriver $elasticSearch
     */
    public function __construct(ElasticSearchDriver $elasticSearch)
    {
        $this->elasticSearch = $elasticSearch;
    }

    /**
     * Warning! Use getRealIndexName() instead
     * @return string
     */
    abstract public function getIndexName(): string;

    /**
     * @return array
     */
    abstract public function createIndexParams(): array;

    /**
     * @param bool $recreate
     *
     * @return array
     * @throws \Exception
     */
    public function createIndex($recreate = true): array
    {
        return $this->safe(function () use ($recreate) {
            if ($recreate) {
                $this->deleteIndex();
            }
            return $this->elasticSearch->getClient()->indices()->create($this->createIndexParams());
        });
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteIndex(): bool
    {
        return $this->safe(function () {
            $client = $this->elasticSearch->getClient();
            if ($client->indices()->exists(['index' => $this->getRealIndexName()])) {
                $client->indices()->delete(['index' => $this->getRealIndexName()]);
            }
            return true;
        }, false);
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function countIndex(): int
    {
        return (int)$this->safe(function () {
            $result = $this->elasticSearch->getClient()->count(['index' => $this->getRealIndexName()]);
            return $result['count'];
        }, 0);
    }

    /**
     * @param $id
     * @param array $body
     * @param string $type
     *
     * @return array|mixed
     * @throws \Exception
     */
    public function indexDoc($id, array $body, string $type = null)
    {
        $params['id'] = $id;
        $params['index'] = $this->getRealIndexName();
        $params['type'] = $type ?: $this->defaultType;
        $params['body'] = $body;
        $params['refresh'] = $this->refresh;
        return $this->safe(function () use ($params) {
            return $this->elasticSearch->getClient()->index($params);
        }, false);
    }

    /**
     * @param $id
     * @param string $type
     *
     * @return array|null
     * @throws \Exception
     */
    public function getDoc($id, string $type = null)
    {
        $params['id'] = $id;
        $params['index'] = $this->getRealIndexName();
        $params['type'] = $type ?: $this->defaultType;
        return $this->safe(function () use ($params) {
            $response = $this->elasticSearch->getClient()->get($params);
            return $response['_source'] ?? null;
        }, false);
    }

    /**
     * @param array $params
     * @param string|null $type
     *
     * @return array
     * @throws \Exception
     */
    public function searchDoc(array $params, string $type = null): array
    {
        $params['index'] = $this->getRealIndexName();
        $params['type'] = $type ?: $this->defaultType;

        return (array)$this->safe(function () use ($params) {
            $this->elasticSearch->setLastSearchQuery($params);
            return (array)$this->elasticSearch->getClient()->search($params);
        });
    }

    /**
     * @param $id
     * @param string|null $type
     *
     * @return mixed
     * @throws \Exception
     */
    public function deleteDoc($id, string $type = null)
    {
        $params['index'] = $this->getRealIndexName();
        $params['type'] = $type ?: $this->defaultType;
        $params['id'] = $id;
        return $this->safe(function () use ($params) {
            return $this->elasticSearch->getClient()->delete($params);
        }, false);
    }

    /**
     * @param $type
     *
     * @return array|mixed
     * @throws \Exception
     */
    public function deleteDocsByType($type)
    {
        $params['index'] = $this->getRealIndexName();
        $params['type'] = $type;
        $params['body'] = ['query' => ['match_all' => new \stdClass()]];
        return $this->safe(function () use ($params) {
            $this->elasticSearch->getClient()->deleteByQuery($params);
        });
    }

    /**
     * @param \Closure $closure
     * @param string|array|mixed $default
     *
     * @return array|mixed
     * @throws \Exception
     */
    protected function safe(\Closure $closure, $default = null)
    {
        try {
            return $closure();
        } catch (\Exception $e) {
            Log::exception($e);
            if ($this->elasticSearch->debug) {
                throw $e;
            }
            return $default;
        }
    }

    /**
     * @return string
     */
    protected function getRealIndexName(): string
    {
        return $this->elasticSearch->getIndexName($this->getIndexName());
    }
}
