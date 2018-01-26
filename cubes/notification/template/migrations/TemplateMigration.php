<?php

namespace cubes\notification\template\migrations;

use Doctrine\DBAL\Connection;
use WebComplete\core\utils\migration\MigrationInterface;
use WebComplete\microDb\MicroDb;

class TemplateMigration implements MigrationInterface
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
        $sql = 'CREATE TABLE IF NOT EXISTS `notification_template` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `code` varchar(100) DEFAULT NULL,
        `subject` varchar(255) DEFAULT NULL,
        `body` mediumtext,
        PRIMARY KEY(`id`)
        ) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8';

        $this->db->exec($sql);
    }

    public function down()
    {
        $sql = 'DROP TABLE IF EXISTS `notification_template`';
        $this->db->exec($sql);
        $this->microDb->getCollection('notification_template')->drop();
    }
}
