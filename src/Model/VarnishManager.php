<?php

namespace Snowdog\DevTest\Model;

use Snowdog\DevTest\Core\Database;

/**
 * Class VarnishManager
 *
 * @package Snowdog\DevTest\Model
 */
class VarnishManager
{
    /**
     * @var Database|\PDO
     */
    private $database;

    /**
     * UserManager constructor.
     *
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @param User $user
     *
     * @return array
     */
    public function getAllByUser(User $user)
    {
        $userId = $user->getUserId();
        /** @var \PDOStatement $query */
        $query = $this->database->prepare('SELECT * FROM varnishes WHERE user_id = :user');
        $query->bindParam(':user', $userId, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, Varnish::class);
    }

    /**
     * @param Website $website
     *
     * @return array
     */
    public function getAllByWebsite(Website $website)
    {
        $websiteId = $website->getWebsiteId();
        /** @var \PDOStatement $query */
        $query = $this->database->prepare('SELECT v.* FROM varnishes as v 
             LEFT JOIN varnishes_websites as vw ON vw.varnish_id = v.varnish_id WHERE vw.website_id = :websiteId');
        $query->bindParam(':websiteId', $websiteId, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, Varnish::class);
    }

    /**
     * @param Varnish $varnish
     *
     * @return array
     */
    public function getWebsites(Varnish $varnish)
    {
        $varnishId = $varnish->getVarnishId();
        /** @var \PDOStatement $query */
        $query = $this->database->prepare('SELECT website_id FROM varnishes_websites WHERE varnish_id = :varnish_id');
        $query->bindParam(':varnish_id', $varnishId, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * @param User $user
     * @param $ip
     *
     * @return string
     */
    public function create(User $user, $ip)
    {
        $userId = $user->getUserId();
        /** @var \PDOStatement $statement */
        $statement = $this->database->prepare('INSERT INTO varnishes (ip, user_id) VALUES (:ip, :user)');
        $statement->bindParam(':ip', $ip, \PDO::PARAM_STR);
        $statement->bindParam(':user', $userId, \PDO::PARAM_INT);
        $statement->execute();
        return $this->database->lastInsertId();
    }

    /**
     * Link website with varnish
     *
     * @param int $varnish
     * @param int $website
     *
     * @return bool
     */
    public function link($varnish, $website)
    {
        $statement = $this->database->prepare(
            'INSERT INTO varnishes_websites (varnish_id, website_id) VALUES (:varnish_id, :website_id)'
        );
        $statement->bindParam(':varnish_id', $varnish, \PDO::PARAM_INT);
        $statement->bindParam(':website_id', $website, \PDO::PARAM_INT);
        return $statement->execute();
    }

    /**
     * Unlink website with varnish
     *
     * @param int $varnish
     * @param int $website
     *
     * @return bool
     */
    public function unlink($varnish, $website)
    {
        $statement = $this->database->prepare(
            'DELETE FROM varnishes_websites WHERE varnish_id = :varnish_id AND website_id = :website_id'
        );
        $statement->bindParam(':varnish_id', $varnish, \PDO::PARAM_INT);
        $statement->bindParam(':website_id', $website, \PDO::PARAM_INT);
        return $statement->execute();
    }
}