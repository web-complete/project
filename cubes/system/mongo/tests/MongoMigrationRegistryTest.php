<?php

namespace cubes\system\mongo\tests;

use cubes\system\mongo\MigrationRegistryMongo;
use cubes\system\mongo\Mongo;
use cubes\system\mongo\tests\classes\TestMigration;
use cubes\system\mongo\tests\classes\TestSecondMigration;
use MongoTestCase;

class MongoMigrationRegistryTest extends MongoTestCase
{

    public function testRegistry()
    {
        $migrationRegistry = $this->container->get(MigrationRegistryMongo::class);
        $registered = $migrationRegistry->getRegistered();
        $this->assertCount(0, $registered);
        $migrationRegistry->register(TestMigration::class);
        $migrationRegistry->register(TestSecondMigration::class);
        $registered = $migrationRegistry->getRegistered();
        $this->assertCount(2, $registered);
    }
}
