<?php

namespace WebComplete\fileDb;

use Closure;

class Collection
{
    /**
     * @var string
     */
    protected $file;
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @param string $file
     */
    public function __construct(string $file)
    {
        $this->file = $file;
    }

    public function fetchAll(Closure $filter = null, Closure $sort = null, int $limit = null, int $offset = null): array
    {
        return [];
    }

    public function fetchOne(Closure $filter = null, Closure $sort = null)
    {

    }

    public function deleteAll(Closure $filter = null, Closure $sort = null, int $limit = null, int $offset = null)
    {

    }

    public function deleteOne(Closure $filter = null, Closure $sort = null)
    {

    }

    public function updateAll()
    {

    }

    public function updateOne()
    {

    }

    public function insertAll()
    {

    }

    public function insertOne()
    {

    }

    public function remove()
    {

    }

    protected function load()
    {

    }

    protected function save()
    {

    }
}
