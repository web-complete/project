<?php

namespace cubes\system\seo\slug\migrations;

use Doctrine\DBAL\Connection;
use WebComplete\core\utils\migration\MigrationInterface;
use WebComplete\microDb\MicroDb;

class SlugMigration implements MigrationInterface
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
        $sql = 'CREATE TABLE IF NOT EXISTS `slug` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(255) DEFAULT NULL,
        `item_class` varchar(255) DEFAULT NULL,
        `item_id` varchar(50) DEFAULT NULL,
        PRIMARY KEY(`id`)
        ) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8';

        $this->db->exec($sql);
        $this->db->exec('CREATE UNIQUE INDEX slug_idx1 ON `slug` (`name`, `item_class`)');
        $this->db->exec('CREATE UNIQUE INDEX slug_idx2 ON `slug` (`item_id`, `item_class`)');
    }

    public function down()
    {
        $sql = 'DROP TABLE IF EXISTS `slug`';
        $this->db->exec($sql);
        $this->microDb->getCollection('slug')->drop();
    }
}
