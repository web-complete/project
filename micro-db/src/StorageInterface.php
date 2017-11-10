<?php

namespace WebComplete\microDb;

interface StorageInterface
{
    /**
     * @param bool $lock
     *
     * @return array
     * @throws \WebComplete\microDb\Exception
     */
    public function load(bool $lock): array;

    /**
     * @param array $collectionData
     */
    public function save(array $collectionData);

    /**
     */
    public function drop();
}
