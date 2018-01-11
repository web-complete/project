<?php

namespace cubes\system\tags\migrations;

use Doctrine\DBAL\Connection;
use WebComplete\core\utils\migration\MigrationInterface;
use WebComplete\microDb\MicroDb;

class TagMigration implements MigrationInterface
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
        $sql = 'CREATE TABLE IF NOT EXISTS `tag` (
              `id` INT(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(50) DEFAULT NULL,
              `slug` varchar(80) DEFAULT NULL,
              `namespace` varchar(128) DEFAULT NULL,
              `ids` text,
              PRIMARY KEY(`id`)
        ) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8';

        $this->db->exec($sql);
        $this->db->exec('CREATE UNIQUE INDEX tag_idx1 ON `tag` (`namespace`, `name`)');
    }

    public function down()
    {
        $sql = 'DROP TABLE IF EXISTS `tag`';
        $this->db->exec($sql);
        $this->microDb->getCollection('tag')->drop();
    }
}
