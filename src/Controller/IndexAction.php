<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\User;
use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\WebsiteManager;
use Snowdog\DevTest\Model\PageManager;

/**
 * Class IndexAction
 * @package Snowdog\DevTest\Controller
 */
class IndexAction
{
    /**
     * @var WebsiteManager
     */
    private $websiteManager;

    /**
     * @var PageManager
     */
    private $pageManager;

    /**
     * @var User
     */
    private $user;

    /**
     * IndexAction constructor.
     * @param UserManager $userManager
     * @param WebsiteManager $websiteManager
     * @param PageManager $pageManager
     */
    public function __construct(UserManager $userManager, WebsiteManager $websiteManager, PageManager $pageManager)
    {
        $this->websiteManager = $websiteManager;
        $this->pageManager = $pageManager;
        if (isset($_SESSION['login'])) {
            $this->user = $userManager->getByLogin($_SESSION['login']);
        }
    }

    /**
     * @return array
     */
    protected function getWebsites()
    {
        if($this->user) {
            return $this->websiteManager->getAllByUser($this->user);
        } 
        return [];
    }

    /**
     * @return int
     */
    protected function getTotalUserPageCount()
    {
        return $this->pageManager->getTotalUserPageCount($this->user);
    }

    /**
     * @return null|string
     */
    protected function getMostRecentlyUserVisitedPage()
    {
        return $this->pageManager->getMostRecentlyUserVisitedPage($this->user);
    }

    /**
     * @return null|string
     */
    protected function getLeastRecentlyUserVisitedPage()
    {
        return $this->pageManager->getLeastRecentlyUserVisitedPage($this->user);
    }

    public function execute()
    {
        if (!isset($_SESSION['login'])) {
            header('Location: /login');
            exit;
        }

        require __DIR__ . '/../view/index.phtml';
    }
}