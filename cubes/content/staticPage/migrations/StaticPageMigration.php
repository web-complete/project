<?php

namespace cubes\content\staticPage\migrations;

use Doctrine\DBAL\Connection;
use WebComplete\core\utils\migration\MigrationInterface;
use WebComplete\microDb\MicroDb;

class StaticPageMigration implements MigrationInterface
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
        $sql = 'CREATE TABLE IF NOT EXISTS `static_page` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `title` varchar(200) DEFAULT NULL,
        `content` text DEFAULT NULL,
        PRIMARY KEY(`id`)
        ) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8';

        $this->db->exec($sql);
    }

    public function down()
    {
        $sql = 'DROP TABLE IF EXISTS `static_page`';
        $this->db->exec($sql);
        $this->microDb->getCollection('static_page')->drop();
    }
}
