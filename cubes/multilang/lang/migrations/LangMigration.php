<?php

namespace cubes\multilang\lang\migrations;

use cubes\multilang\lang\LangService;
use Doctrine\DBAL\Connection;
use WebComplete\core\utils\migration\MigrationInterface;
use WebComplete\microDb\MicroDb;

class LangMigration implements MigrationInterface
{

    /**
     * @var Connection
     */
    private $db;
    /**
     * @var MicroDb
     */
    private $microDb;
    /**
     * @var LangService
     */
    private $langService;

    /**
     * @param Connection $db
     * @param MicroDb $microDb
     * @param LangService $langService
     */
    public function __construct(Connection $db, MicroDb $microDb, LangService $langService)
    {
        $this->db = $db;
        $this->microDb = $microDb;
        $this->langService = $langService;
    }

    public function up()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `lang` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `code` varchar(10) DEFAULT NULL,
        `name` varchar(30) DEFAULT NULL,
        `sort` tinyint DEFAULT 100,
        `is_main` tinyint(1),
        PRIMARY KEY(`id`)
        ) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8';

        $this->db->exec($sql);
        $this->langService->save($this->langService->createFromData([
            'code' => 'ru',
            'name' => 'Русский',
            'sort' => 100,
            'is_main' => true
        ]));

    }

    public function down()
    {
        $sql = 'DROP TABLE IF EXISTS `lang`';
        $this->db->exec($sql);
        $this->microDb->getCollection('lang')->drop();
    }
}
