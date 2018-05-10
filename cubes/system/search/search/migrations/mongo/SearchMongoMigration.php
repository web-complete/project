<?php

namespace cubes\system\search\search\migrations\mongo;

use cubes\system\mongo\Mongo;
use cubes\system\user\User;
use cubes\system\user\UserService;
use WebComplete\core\utils\migration\MigrationInterface;
use WebComplete\rbac\Rbac;

class SearchMongoMigration implements MigrationInterface
{
    /**
     * @var Mongo
     */
    private $mongo;

    /**
     * @param Mongo $mongo
     */
    public function __construct(
        Mongo $mongo
    ) {
        $this->mongo = $mongo;
    }

    public function up()
    {
        try {
            $this->mongo->selectCollection('search')->dropIndexes();
        } catch (\Exception $e) {

        }

        $indexes = [
            [
                'key' => [
                    'title' => 'text',
                    'content' => 'text',
                    'extra' => 'text'
                ],
                'weights' => [
                    'title' => 20,
                    'content' => 10,
                ],
                'name' => 'title_content_extra'
            ],
        ];
        $this->mongo->selectCollection('search')->createIndexes($indexes);
    }

    public function down()
    {
        $this->mongo->selectCollection('search')->dropIndexes();
    }
}
