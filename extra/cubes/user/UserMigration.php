<?php

namespace WebComplete\extra\cubes\user;

use Doctrine\DBAL\Connection;
use WebComplete\core\utils\migration\MigrationInterface;

class UserMigration implements MigrationInterface
{

    /**
     * @var Connection
     */
    private $db;

    /**
     * @param Connection $db
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function up()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `user` (
              `id` INT(11) NOT NULL AUTO_INCREMENT,
              `login` varchar(50) DEFAULT NULL,
              `email` varchar(100) DEFAULT NULL,
              `password` varchar(50) DEFAULT NULL,
              `token` varchar(50) DEFAULT NULL,
              `first_name` varchar(50) DEFAULT NULL,
              `last_name` varchar(50) DEFAULT NULL,
              `sex` ENUM(\'M\', \'F\') DEFAULT \'M\',
              `last_visit` timestamp NULL DEFAULT NULL,
              `f_active` tinyint(1) UNSIGNED DEFAULT 1
              `created_on` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              `updated_on` TIMESTAMP NULL DEFAULT NULL,
              PRIMARY KEY(`id`),
              UNIQUE(`class`)
        ) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8';

        $this->db->exec($sql);
        $this->db->exec('CREATE UNIQUE INDEX user_idx1 ON `user` (`login`)');
        $this->db->exec('CREATE UNIQUE INDEX user_idx2 ON `user` (`email`)');
        $this->db->exec('CREATE UNIQUE INDEX user_idx3 ON `user` (`token`)');
    }

    public function down()
    {
        $sql = 'DROP TABLE IF EXISTS `user`';
        $this->db->exec($sql);
    }
}
