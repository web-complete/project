<?php

namespace cubes\system\file\migrations;

use Doctrine\DBAL\Connection;
use WebComplete\core\utils\alias\AliasService;
use WebComplete\core\utils\migration\MigrationInterface;

class FileMigration implements MigrationInterface
{

    /**
     * @var Connection
     */
    private $db;
    /**
     * @var AliasService
     */
    private $aliasService;

    /**
     * @param Connection $db
     * @param AliasService $aliasService
     */
    public function __construct(Connection $db, AliasService $aliasService)
    {
        $this->db = $db;
        $this->aliasService = $aliasService;
    }

    public function up()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `file` (
              `id` INT(11) NOT NULL AUTO_INCREMENT,
              `code` varchar(50) DEFAULT NULL,
              `file_name` varchar(255) DEFAULT NULL,
              `mime_type` varchar(200) DEFAULT NULL,
              `base_dir` varchar(255) DEFAULT NULL,
              `url` varchar(255) DEFAULT NULL,
              `sort` int unsigned DEFAULT 100,
              `data` varchar(1000) DEFAULT NULL,
              PRIMARY KEY(`id`)
        ) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8';

        $this->db->exec($sql);
        $this->db->exec('CREATE UNIQUE INDEX file_idx1 ON `file` (`code`, `sort`)');
    }

    public function down()
    {
        $sql = 'DROP TABLE IF EXISTS `file`';
        $this->db->exec($sql);
        @\unlink($this->aliasService->get('@storage/micro-db/app_file.fdb'));
    }
}
