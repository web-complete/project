<?php

namespace WebComplete\microDb;

use Closure;

class Collection
{
    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param Closure|null $filter
     * @param Closure|null $sort
     * @param int|null $limit
     * @param int $offset
     *
     * @return array
     * @throws \WebComplete\microDb\Exception
     */
    public function fetchAll(Closure $filter = null, Closure $sort = null, int $limit = null, int $offset = 0): array
    {
        $collectionData = $this->storage->load(false);
        if (!isset($collectionData['items'])) {
            $collectionData['items'] = [];
        }
        $items = &$collectionData['items'];
        if ($sort) {
            \uasort($items, $sort);
        }
        if ($filter) {
            $items = \array_filter($items, $filter);
        }
        if ($limit) {
            $items = \array_slice($items, $offset, $limit);
        }
        return $items;
    }

    /**
     * @param Closure|null $filter
     * @param Closure|null $sort
     *
     * @return array|null
     * @throws \WebComplete\microDb\Exception
     */
    public function fetchOne(Closure $filter = null, Closure $sort = null)
    {
        $result = $this->fetchAll($filter, $sort);
        return $result ? (array)\reset($result) : null;
    }

    /**
     * @param Closure $filter
     *
     * @throws \WebComplete\microDb\Exception
     */
    public function delete(Closure $filter)
    {
        $collectionData = $this->storage->load(true);
        if (!isset($collectionData['items'])) {
            $collectionData['items'] = [];
        }
        $items = &$collectionData['items'];

        foreach ($items as $k => $item) {
            if ($filter($item)) {
                unset($items[$k]);
            }
        }
        $this->storage->save($collectionData);
    }

    /**
     * @param Closure $filter
     * @param array $data
     * @param string $idField
     *
     * @throws \WebComplete\microDb\Exception
     */
    public function update(Closure $filter, array $data, string $idField = 'id')
    {
        unset($data[$idField]);
        $collectionData = $this->storage->load(true);
        if (!isset($collectionData['items'])) {
            $collectionData['items'] = [];
        }
        $items = &$collectionData['items'];
        foreach ($items as $k => $item) {
            if ($filter($item)) {
                $items[$k] = \array_merge($item, $data);
            }
        }
        $this->storage->save($collectionData);
    }

    /**
     * @param array $item
     * @param string $idField
     *
     * @return int last insert id
     * @throws \WebComplete\microDb\Exception
     */
    public function insert(array $item, string $idField = 'id'): int
    {
        $collectionData = $this->storage->load(true);
        if (!isset($collectionData['items'])) {
            $collectionData['items'] = [];
        }
        if (!isset($collectionData['inc'])) {
            $collectionData['inc'] = 1;
        }
        $item[$idField] = $collectionData['inc']++;
        $collectionData['items'][] = $item;
        $this->storage->save($collectionData);
        return $item[$idField];
    }

    /**
     * @param array $items
     * @param string $idField
     *
     * @throws \WebComplete\microDb\Exception
     */
    public function insertBatch(array $items, string $idField = 'id')
    {
        $collectionData = $this->storage->load(true);
        if (!isset($collectionData['items'])) {
            $collectionData['items'] = [];
        }
        if (!isset($collectionData['inc'])) {
            $collectionData['inc'] = 1;
        }
        foreach ($items as &$item) {
            $item[$idField] = $collectionData['inc']++;
        }
        unset($item);
        $this->storage->save(\array_merge($collectionData, $items));
    }

    /**
     */
    public function drop()
    {
        $this->storage->drop();
    }
}
