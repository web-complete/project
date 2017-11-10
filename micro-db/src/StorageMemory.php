<?php

namespace WebComplete\microDb;

class StorageMemory implements StorageInterface
{

    /**
     * @var array
     */
    protected static $mem = [];
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

    /**
     * @param bool $lock
     *
     * @return array
     */
    public function load(bool $lock): array
    {
        return static::$mem[$this->file] ?? [];
    }

    /**
     * @param array $collectionData
     */
    public function save(array $collectionData)
    {
        static::$mem[$this->file] = $collectionData;
    }

    /**
     */
    public static function clear()
    {
        static::$mem = [];
    }

    /**
     * @return array
     */
    public static function dump(): array
    {
        return static::$mem;
    }

    /**
     */
    public function drop()
    {
        unset(static::$mem[$this->file]);
    }
}
