<?php

namespace cubes\system\file\migrations;

use Doctrine\DBAL\Connection;
use WebComplete\core\utils\migration\MigrationInterface;
use WebComplete\microDb\MicroDb;

class FileMigration implements MigrationInterface
{

    /**
     * @var Connection
     */
    private $db;
    /**
     * @var MicroDb
     */
    private $microDb;

    public function __construct(Connection $db, MicroDb $microDb)
    {
        $this->db = $db;
        $this->microDb = $microDb;
    }

    public function up()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `file` (
              `id` INT(11) NOT NULL AUTO_INCREMENT,
              `code` varchar(50) DEFAULT NULL,
              `file_name` varchar(255) DEFAULT NULL,
              `mime_type` varchar(200) DEFAULT NULL,
              `base_dir` varchar(255) DEFAULT NULL,
              `url` varchar(255) DEFAULT NULL,
              `sort` int unsigned DEFAULT 100,
              `data` varchar(1000) DEFAULT NULL,
              PRIMARY KEY(`id`)
        ) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8';

        $this->db->exec($sql);
        $this->db->exec('CREATE UNIQUE INDEX file_idx1 ON `file` (`code`, `sort`)');
    }

    public function down()
    {
        $sql = 'DROP TABLE IF EXISTS `file`';
        $this->db->exec($sql);
        $this->microDb->getCollection('file')->drop();
    }
}
