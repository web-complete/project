<?php

namespace cubes\ecommerce\classifier\migrations;

use Doctrine\DBAL\Connection;
use WebComplete\core\utils\migration\MigrationInterface;
use WebComplete\microDb\MicroDb;

class ClassifierMigration implements MigrationInterface
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
        $sql = 'CREATE TABLE IF NOT EXISTS `classifier` (
              `id` INT(11) NOT NULL AUTO_INCREMENT,
              `parent_id` INT(11),
              `sort` INT,
              `title` varchar(100) DEFAULT NULL,
              `category_id` INT(11),
              `multilang` text,
              PRIMARY KEY(`id`)
        ) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8';

        $this->db->exec($sql);
    }

    public function down()
    {
        $sql = 'DROP TABLE IF EXISTS `classifier`';
        $this->db->exec($sql);
        $this->microDb->getCollection('classifier')->drop();
    }
}
