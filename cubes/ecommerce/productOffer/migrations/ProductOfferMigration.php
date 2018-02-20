<?php

namespace cubes\ecommerce\productOffer\migrations;

use Doctrine\DBAL\Connection;
use WebComplete\core\utils\migration\MigrationInterface;
use WebComplete\microDb\MicroDb;

class ProductOfferMigration implements MigrationInterface
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
        $sql = 'CREATE TABLE IF NOT EXISTS `product_offer` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `sku` varchar(50) DEFAULT NULL,
        `name` varchar(500) DEFAULT NULL,
        `product_id` INT(11),
        `price` DECIMAL(10,2),
        `properties` text,
        `properties_multilang` text,
        `multilang` text,
        PRIMARY KEY(`id`)
        ) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8';

        $this->db->exec($sql);
        $this->db->exec('CREATE UNIQUE INDEX offer_idx1 ON `product_offer` (`sku`)');
    }

    public function down()
    {
        $sql = 'DROP TABLE IF EXISTS `product_offer`';
        $this->db->exec($sql);
        $this->microDb->getCollection('product_offer')->drop();
    }
}
