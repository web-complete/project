<?php

namespace cubes\system\tags\migrations;

use Doctrine\DBAL\Driver\Connection;
use WebComplete\core\utils\alias\AliasService;
use WebComplete\core\utils\migration\MigrationInterface;

class TagMigration implements MigrationInterface
{

    /**
     * @var Connection
     */
    private $db;
    /**
     * @var AliasService
     */
    private $aliasService;

    public function __construct(Connection $db, AliasService $aliasService)
    {
        $this->db = $db;
        $this->aliasService = $aliasService;
    }

    public function up()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `tag` (
              `id` INT(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(50) DEFAULT NULL,
              `slug` varchar(80) DEFAULT NULL,
              `namespace` varchar(128) DEFAULT NULL,
              `ids` text,
              PRIMARY KEY(`id`)
        ) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8';

        $this->db->exec($sql);
        $this->db->exec('CREATE UNIQUE INDEX tag_idx1 ON `tag` (`namespace`, `name`)');
    }

    public function down()
    {
        $sql = 'DROP TABLE IF EXISTS `tag`';
        $this->db->exec($sql);
        @\unlink($this->aliasService->get('@storage/micro-db/app_tag.fdb'));
    }
}
