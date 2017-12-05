<?php

namespace cubes\system\user\migrations;

use cubes\system\user\User;
use cubes\system\user\UserService;
use Doctrine\DBAL\Connection;
use WebComplete\core\utils\alias\AliasService;
use WebComplete\core\utils\migration\MigrationInterface;

class UserMigration implements MigrationInterface
{

    /**
     * @var Connection
     */
    private $db;
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var AliasService
     */
    private $aliasService;

    /**
     * @param Connection $db
     * @param UserService $userService
     * @param AliasService $aliasService
     */
    public function __construct(Connection $db, UserService $userService, AliasService $aliasService)
    {
        $this->db = $db;
        $this->userService = $userService;
        $this->aliasService = $aliasService;
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
              `f_active` tinyint(1) UNSIGNED DEFAULT 1,
              `roles` varchar(500),
              `created_on` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              `updated_on` TIMESTAMP NULL DEFAULT NULL,
              PRIMARY KEY(`id`)
        ) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8';

        $this->db->exec($sql);
        $this->db->exec('CREATE UNIQUE INDEX user_idx1 ON `user` (`login`)');
        $this->db->exec('CREATE UNIQUE INDEX user_idx2 ON `user` (`email`)');
        $this->db->exec('CREATE UNIQUE INDEX user_idx3 ON `user` (`token`)');

        $this->createAdmin();
    }

    public function down()
    {
        $sql = 'DROP TABLE IF EXISTS `user`';
        $this->db->exec($sql);
        @\unlink($this->aliasService->get('@storage/micro-db/app_user.fdb'));
    }

    protected function createAdmin()
    {
        /** @var User $user */
        $user = $this->userService->create();
        $user->setFirstName('Administrator');
        $user->setLogin('admin');
        $user->setPassword('123qwe4');
        $user->setRoles(['admin']);
        $this->userService->save($user);
    }
}
