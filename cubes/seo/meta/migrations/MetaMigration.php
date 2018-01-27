<?php

namespace cubes\seo\meta\migrations;

use Doctrine\DBAL\Connection;
use WebComplete\core\utils\migration\MigrationInterface;
use WebComplete\microDb\MicroDb;

class MetaMigration implements MigrationInterface
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
        $sql = 'CREATE TABLE IF NOT EXISTS `meta` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `url` varchar(255) DEFAULT NULL,
        `title` varchar(255) DEFAULT NULL,
        `description` varchar(255) DEFAULT NULL,
        `keywords` varchar(255) DEFAULT NULL,
        PRIMARY KEY(`id`)
        ) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8';

        $this->db->exec($sql);
        $this->db->exec('CREATE UNIQUE INDEX meta_idx1 ON `meta` (`url`)');
    }

    public function down()
    {
        $sql = 'DROP TABLE IF EXISTS `meta`';
        $this->db->exec($sql);
        $this->microDb->getCollection('meta')->drop();
    }
}
