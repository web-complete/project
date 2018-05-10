<?php

namespace cubes\system\multilang\lang\migrations\mongo;

use cubes\system\mongo\Mongo;
use cubes\system\multilang\lang\LangService;
use WebComplete\core\utils\migration\MigrationInterface;

class LangMongoMigration implements MigrationInterface
{

    /**
     * @var Mongo
     */
    private $mongo;
    /**
     * @var LangService
     */
    private $langService;

    /**
     * @param Mongo $mongo
     * @param LangService $langService
     */
    public function __construct(Mongo $mongo, LangService $langService)
    {
        $this->mongo = $mongo;
        $this->langService = $langService;
    }

    public function up()
    {
        $this->langService->save($this->langService->createFromData([
            'code' => 'ru',
            'name' => 'Русский',
            'sort' => 100,
            'is_main' => true
        ]));
    }

    public function down()
    {
        $this->mongo->selectCollection('lang')->deleteMany([]);
    }
}
