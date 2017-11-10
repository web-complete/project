<?php

namespace WebComplete\microDb;

class MicroDb
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
     * @var string
     */
    protected $type;
    /**
     * @var Factory
     */
    protected $factory;

    /**
     * @param string $storageDir
     * @param string $dbName
     * @param string $type file or memory
     * @param Factory $factory
     */
    public function __construct(string $storageDir, string $dbName, string $type = 'file', Factory $factory = null)
    {
        $this->storageDir = \rtrim($storageDir, '/');
        $this->dbName = $this->normalize($dbName);
        $this->setType($type);
        $this->factory = $factory ?? new Factory();
    }

    /**
     * @param string $type file or memory
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @param string $collectionName
     *
     * @return Collection
     */
    public function getCollection(string $collectionName): Collection
    {
        $collectionFile = $this->getCollectionFilePath($collectionName);
        $storage = $this->factory->storage($collectionFile, $this->type);
        return $this->factory->collection($storage);
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
     * @param string $value
     *
     * @return string
     */
    private function normalize(string $value): string
    {
        return \preg_replace(
            '/[^a-z0-9\-]/',
            '',
            \strtolower(\str_replace('_', '-', $value))
        );
    }
}
