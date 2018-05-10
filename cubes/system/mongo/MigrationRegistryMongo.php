<?php

namespace cubes\system\mongo;

use MongoDB\Collection;
use WebComplete\core\utils\container\ContainerInterface;
use WebComplete\core\utils\migration\AbstractMigrationRegistry;

class MigrationRegistryMongo extends AbstractMigrationRegistry
{
    /**
     * @var Collection
     */
    protected $collection;
    protected $migrationTable = '_migrations';

    /**
     * @param ContainerInterface $container
     * @param Mongo $mongo
     * @throws \Exception
     */
    public function __construct(ContainerInterface $container, Mongo $mongo)
    {
        parent::__construct($container);
        $this->collection = $mongo->selectCollection($this->migrationTable);
    }

    /**
     * check or create initial registry
     *
     */
    public function initRegistry() : void
    {
    }

    /**
     * @return string[] migration classes
     * @throws \Exception
     */
    public function getRegistered(): array
    {
        $this->initRegistry();
        $result = [];
        $found = $this->collection->find();
        $rows = $found->toArray();
        foreach ($rows as $row) {
            if (isset($row['class'])) {
                    $result[] = $row['class'];
            }
        }
        return $result;
    }

    /**
     * @param string $class migration class
     *
     * @return bool
     * @throws \Exception
     */
    public function isRegistered(string $class): bool
    {
        return \in_array($class, $this->getRegistered(), true);
    }

    /**
     * @param string $class migration class
     * @throws \Exception
     */
    public function register(string $class) : void
    {
        $this->initRegistry();
        if (!$this->isRegistered($class)) {
            $migration = $this->getMigration($class);
            $migration->up();
            $this->collection->insertOne(['class' => $class]);
        }
    }

    /**
     * @param string $class migration class
     * @throws \Exception
     */
    public function unregister(string $class) : void
    {
        $this->initRegistry();
        if ($this->isRegistered($class)) {
            $migration = $this->getMigration($class);
            $migration->down();
            $this->collection->deleteOne(['class' => $class]);
        }
    }
}
