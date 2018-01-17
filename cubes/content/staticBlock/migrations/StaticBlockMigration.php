<?php

namespace cubes\content\staticBlock\migrations;

use Doctrine\DBAL\Connection;
use WebComplete\core\utils\migration\MigrationInterface;
use WebComplete\microDb\MicroDb;

class StaticBlockMigration implements MigrationInterface
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
        $sql = 'CREATE TABLE IF NOT EXISTS `static_block` (
              `id` INT(11) NOT NULL AUTO_INCREMENT,
              `namespace` varchar(100) NOT NULL,
              `name` varchar(255) NOT NULL,
              `type` tinyint(1) DEFAULT 1,
              `content` text,
              `multilang` text,
              PRIMARY KEY(`id`)
        ) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8';

        $this->db->exec($sql);
        $this->db->exec('CREATE UNIQUE INDEX static_block_idx1 ON `static_block` (`namespace`, `name`)');
    }

    public function down()
    {
        $sql = 'DROP TABLE IF EXISTS `static_block`';
        $this->db->exec($sql);
        $this->microDb->getCollection('static_block')->drop();
    }
}
