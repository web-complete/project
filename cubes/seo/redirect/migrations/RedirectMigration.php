<?php

namespace cubes\seo\redirect\migrations;

use Doctrine\DBAL\Connection;
use WebComplete\core\utils\migration\MigrationInterface;
use WebComplete\microDb\MicroDb;

class RedirectMigration implements MigrationInterface
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
        $sql = 'CREATE TABLE IF NOT EXISTS `redirect` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `url_from` varchar(500) DEFAULT NULL,
        `url_to` varchar(500) DEFAULT NULL,
        PRIMARY KEY(`id`)
        ) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8';

        $this->db->exec($sql);
        $this->db->exec('CREATE UNIQUE INDEX redirect_idx1 ON `redirect` (`url_from`)');
    }

    public function down()
    {
        $sql = 'DROP TABLE IF EXISTS `redirect`';
        $this->db->exec($sql);
        $this->microDb->getCollection('redirect')->drop();
    }
}
