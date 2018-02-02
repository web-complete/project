<?php

namespace cubes\content\menu\migrations;

use Doctrine\DBAL\Connection;
use WebComplete\core\utils\migration\MigrationInterface;
use WebComplete\microDb\MicroDb;

class MenuMigration implements MigrationInterface
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
        $sql = 'CREATE TABLE IF NOT EXISTS `menu` (
              `id` INT(11) NOT NULL AUTO_INCREMENT,
              `parent_id` INT(11),
              `sort` INT,
              `title` varchar(100) DEFAULT NULL,
              `type` INT,
              `url` varchar(200) DEFAULT NULL,
              `page` INT(11),
              `multilang` text,
              PRIMARY KEY(`id`)
        ) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8';

        $this->db->exec($sql);
        $this->db->exec('CREATE INDEX menu_idx1 ON `menu` (`parent_id`)');
    }

    public function down()
    {
        $sql = 'DROP TABLE IF EXISTS `menu`';
        $this->db->exec($sql);
        $this->microDb->getCollection('menu')->drop();
    }
}
