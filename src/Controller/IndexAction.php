<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\User;
use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\WebsiteManager;
use Snowdog\DevTest\Model\PageManager;

class IndexAction
{
    /**
     * @var WebsiteManager
     */
    private $websiteManager;

    /**
     * @var
     */
    private $pageManager;

    /**
     * @var User
     */
    private $user;

    public function __construct(UserManager $userManager, WebsiteManager $websiteManager, PageManager $pageManager)
    {
        $this->websiteManager = $websiteManager;
        $this->pageManager = $pageManager;
        if (isset($_SESSION['login'])) {
            $this->user = $userManager->getByLogin($_SESSION['login']);
        }
    }

    protected function getWebsites()
    {
        if($this->user) {
            return $this->websiteManager->getAllByUser($this->user);
        } 
        return [];
    }

    protected function getTotalUserPageCount()
    {
        return $this->pageManager->getTotalUserPageCount($this->user);
    }

    protected function getMostRecentlyUserVisitedPage()
    {
        return $this->pageManager->getMostRecentlyUserVisitedPage($this->user);
    }

    protected function getLeastRecentlyUserVisitedPage()
    {
        return $this->pageManager->getLeastRecentlyUserVisitedPage($this->user);
    }

    public function execute()
    {
        require __DIR__ . '/../view/index.phtml';
    }
}