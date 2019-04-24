<?php

namespace Snowdog\DevTest\Model;

use Snowdog\DevTest\Core\Database;

class PageManager
{
    /**
     * @var Database|\PDO
     */
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getAllByWebsite(Website $website)
    {
        $websiteId = $website->getWebsiteId();
        /** @var \PDOStatement $query */
        $query = $this->database->prepare('SELECT * FROM pages WHERE website_id = :website');
        $query->bindParam(':website', $websiteId, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, Page::class);
    }

    public function create(Website $website, $url)
    {
        $websiteId = $website->getWebsiteId();
        /** @var \PDOStatement $statement */
        $statement = $this->database->prepare('INSERT INTO pages (url, website_id) VALUES (:url, :website)');
        $statement->bindParam(':url', $url, \PDO::PARAM_STR);
        $statement->bindParam(':website', $websiteId, \PDO::PARAM_INT);
        $statement->execute();
        return $this->database->lastInsertId();
    }

    public function setLastVisited(Page $page)
    {
        $pageId = $page->getPageId();
        $now = date('Y-m-d H:i:s');

        /** @var \PDOStatement $statement */
        $statement = $this->database->prepare('UPDATE pages SET last_visited = :now WHERE page_id = :id');
        $statement->bindParam(':now', $now, \PDO::PARAM_STR);
        $statement->bindParam(':id', $pageId, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function getTotalUserPageCount(User $user)
    {
        $userId = $user->getUserId();

        $query = $this->database->prepare(
            'SELECT COUNT(*) FROM pages p INNER JOIN websites w ON p.website_id = w.website_id where w.user_id = :user'
        );
        $query->bindParam(':user', $userId, \PDO::PARAM_INT);
        $query->execute();

        return $query->fetchColumn();
    }

    public function getMostRecentlyUserVisitedPage(User $user)
    {
        $userId = $user->getUserId();

        $query = $this->database->prepare(
            'SELECT w.hostname, p.url FROM pages p INNER JOIN websites w ON w.website_id = p.website_id WHERE w.user_id = :user_id ORDER BY last_visited DESC LIMIT 1'
        );
        $query->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_ASSOC);

        return count($result) > 0 ? $result[0]['hostname'] . '/' . $result[0]['url'] : null;
    }

    public function getLeastRecentlyUserVisitedPage(User $user)
    {
        $userId = $user->getUserId();

        $query = $this->database->prepare(
            'SELECT w.hostname, p.url FROM pages p INNER JOIN websites w ON w.website_id = p.website_id WHERE w.user_id = :user_id ORDER BY last_visited ASC LIMIT 1'
        );
        $query->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_ASSOC);

        return count($result) > 0 ? $result[0]['hostname'] . '/' . $result[0]['url'] : null;
    }
}
