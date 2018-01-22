<?php

namespace cubes\multilang\translation\migrations;

use Doctrine\DBAL\Connection;
use WebComplete\core\utils\migration\MigrationInterface;
use WebComplete\microDb\MicroDb;

class TranslationMigration implements MigrationInterface
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
        $sql = 'CREATE TABLE IF NOT EXISTS `translation` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `namespace` varchar(50) DEFAULT NULL,
        `original` varchar(1000) DEFAULT NULL,
        `translations` mediumtext,
        PRIMARY KEY(`id`)
        ) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8';

        $this->db->exec($sql);
    }

    public function down()
    {
        $sql = 'DROP TABLE IF EXISTS `translation`';
        $this->db->exec($sql);
        $this->microDb->getCollection('translation')->drop();
    }
}
