<?php

namespace WebComplete\fileDb;

class Client
{

    const EXTENSION = 'fdb';

    /**
     * @var string
     */
    protected $storageDir;
    /**
     * @var string
     */
    protected $dbName;

    /**
     * @param string $storageDir
     * @param string $dbName
     */
    public function __construct(string $storageDir, string $dbName)
    {
        $this->storageDir = \rtrim($storageDir, '/');
        $this->dbName = $this->normalize($dbName);
    }

    /**
     * @param string $collectionName
     *
     * @return Collection
     */
    public function getCollection(string $collectionName): Collection
    {
        $collectionFile = $this->getCollectionFilePath($collectionName);
        return $this->createCollectionObject($collectionFile);
    }

    /**
     * @param string $collectionName
     *
     * @return string
     */
    protected function getCollectionFilePath(string $collectionName): string
    {
        return $this->storageDir . '/' . $this->dbName . '_'
            . $this->normalize($collectionName) . '.' . self::EXTENSION;
    }

    /**
     * Factory method
     * @param string $collectionFile
     *
     * @return Collection
     */
    protected function createCollectionObject(string $collectionFile): Collection
    {
        return new Collection($collectionFile);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    private function normalize(string $value): string
    {
        return \preg_replace(
            '/^[a-z0-9\-]/',
            '',
            \strtolower(\str_replace('_', '-', $value))
        );
    }
}
