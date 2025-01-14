<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\PageManager;
use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\Website;
use Snowdog\DevTest\Model\WebsiteManager;

/**
 * Class WebsiteAction
 * @package Snowdog\DevTest\Controller
 */
class WebsiteAction
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
     * @var UserManager
     */
    private $userManager;
    /**
     * @var Website
     */
    private $website;

    /**
     * WebsiteAction constructor.
     * @param UserManager $userManager
     * @param WebsiteManager $websiteManager
     * @param PageManager $pageManager
     */
    public function __construct(UserManager $userManager, WebsiteManager $websiteManager, PageManager $pageManager)
    {
        $this->websiteManager = $websiteManager;
        $this->pageManager = $pageManager;
        $this->userManager = $userManager;
    }

    /**
     * @param $id
     */
    public function execute($id)
    {
        if (!isset($_SESSION['login'])) {
            header('Location: /login');
            exit;
        }

        $user = $this->userManager->getByLogin($_SESSION['login']);
        $website = $this->websiteManager->getById($id);

        if ($website->getUserId() == $user->getUserId()) {
            $this->website = $website;
        }

        require __DIR__ . '/../view/website.phtml';
    }

    /**
     * @return array
     */
    protected function getPages()
    {
        if($this->website) {
            return $this->pageManager->getAllByWebsite($this->website);
        } 
        return [];
    }
}