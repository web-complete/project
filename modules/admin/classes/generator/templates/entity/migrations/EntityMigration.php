<?php

use modules\admin\classes\generator\Config;

/** @var Config $config */

?>


namespace <?=$config->namespace ?>\migrations;

use Doctrine\DBAL\Connection;
use WebComplete\core\utils\migration\MigrationInterface;
use WebComplete\microDb\MicroDb;

class <?=$config->nameCamel ?>Migration implements MigrationInterface
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
        $sql = 'CREATE TABLE IF NOT EXISTS `<?=$config->nameUnderscore ?>` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(500) DEFAULT NULL,
        PRIMARY KEY(`id`)
        ) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8';

        $this->db->exec($sql);
    }

    public function down()
    {
        $sql = 'DROP TABLE IF EXISTS `<?=$config->nameUnderscore ?>`';
        $this->db->exec($sql);
        $this->microDb->getCollection('<?=$config->nameUnderscore ?>')->drop();
    }
}
