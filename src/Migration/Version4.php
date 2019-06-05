<?php

namespace Snowdog\DevTest\Migration;

use Snowdog\DevTest\Core\Database;

/**
 * Class Version4
 * @package Snowdog\DevTest\Migration
 */
class Version4
{
    /**
     * @var Database|\PDO
     */
    private $database;

    /**
     * Version4 constructor.
     *
     * @param Database $database
     */
    public function __construct(
        Database $database
    ) {
        $this->database = $database;
    }

    public function __invoke()
    {
        $this->createVarnishTable();
        $this->createVarnishAssociationTable();
    }

    private function createVarnishTable()
    {
        $createQuery = <<<SQL
CREATE TABLE `varnishes` (
  `varnish_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`varnish_id`),
  UNIQUE KEY `ip_user_id` (`ip`, `user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `varnish_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SQL;
        $this->database->exec($createQuery);
    }

    private function createVarnishAssociationTable()
    {
        $createQuery = <<<SQL
CREATE TABLE `varnishes_websites` (
  `varnish_website_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `website_id` int(11) unsigned NOT NULL,
  `varnish_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`varnish_website_id`),
  UNIQUE KEY `varnish_website_key` (`website_id`, `varnish_id`),
  KEY `website_id` (`website_id`),
  CONSTRAINT `website_fk` FOREIGN KEY (`website_id`) REFERENCES `websites` (`website_id`),
  KEY `varnish_id` (`varnish_id`),
  CONSTRAINT `varnish_fk` FOREIGN KEY (`varnish_id`) REFERENCES `varnishes` (`varnish_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SQL;
        $this->database->exec($createQuery);
    }
}