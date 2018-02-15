<?php

namespace cubes\system\storage\migrations;

use Doctrine\DBAL\Connection;
use WebComplete\core\utils\migration\MigrationInterface;
use WebComplete\microDb\MicroDb;

class StorageMigration implements MigrationInterface
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
     * @param Connection $db
     * @param MicroDb $microDb
     */
    public function __construct(Connection $db, MicroDb $microDb)
    {
        $this->db = $db;
        $this->microDb = $microDb;
    }

    public function up()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `storage` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `key` varchar(50) DEFAULT NULL,
        `value` text,
        PRIMARY KEY(`id`)
        ) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8';

        $this->db->exec($sql);
        $this->db->exec('CREATE UNIQUE INDEX storage_idx1 ON `storage` (`key`)');
    }

    public function down()
    {
        $sql = 'DROP TABLE IF EXISTS `storage`';
        $this->db->exec($sql);
        $this->microDb->getCollection('storage')->drop();
    }
}
