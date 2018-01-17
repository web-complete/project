<?php

namespace cubes\content\article\migrations;

use Doctrine\DBAL\Connection;
use WebComplete\core\utils\migration\MigrationInterface;
use WebComplete\microDb\MicroDb;

class ArticleMigration implements MigrationInterface
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
        $sql = 'CREATE TABLE IF NOT EXISTS `article` (
              `id` INT(11) NOT NULL AUTO_INCREMENT,
              `title` varchar(500) DEFAULT NULL,
              `description` varchar(1000) DEFAULT NULL,
              `image_list` varchar(255) DEFAULT NULL,
              `image_detail` varchar(255) DEFAULT NULL,
              `text` text,
              `tags` varchar(500),
              `viewed` INT UNSIGNED DEFAULT 0,
              `is_active` tinyint(1) UNSIGNED DEFAULT 1,
              `created_on` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              `updated_on` TIMESTAMP NULL DEFAULT NULL,
              `published_on` TIMESTAMP NULL DEFAULT NULL,
              `multilang` text,
              PRIMARY KEY(`id`)
        ) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8';

        $this->db->exec($sql);
        $this->db->exec('CREATE UNIQUE INDEX article_idx1 ON `article` (`published_on`)');
        $this->db->exec('CREATE UNIQUE INDEX article_idx2 ON `article` (`viewed`)');
    }

    public function down()
    {
        $sql = 'DROP TABLE IF EXISTS `article`';
        $this->db->exec($sql);
        $this->microDb->getCollection('article')->drop();
    }
}
