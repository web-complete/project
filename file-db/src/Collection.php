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

    public function delete(Closure $filter)
    {

    }

    public function update(Closure $filter, array $data, bool $partial = false)
    {

    }

    public function insert(array $item)
    {

    }

    public function insertBatch(array $items)
    {

    }

    public function drop()
    {

    }

    protected function load(bool $lock = false): array
    {

    }

    protected function save(array $collectionData)
    {

    }
}
