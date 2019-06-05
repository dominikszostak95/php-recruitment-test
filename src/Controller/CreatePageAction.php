<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\PageManager;
use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\WebsiteManager;

/**
 * Class CreatePageAction
 * @package Snowdog\DevTest\Controller
 */
class CreatePageAction
{
    /** @var WebsiteManager */
    private $websiteManager;

    /** @var PageManager */
    private $pageManager;

    /** @var UserManager */
    private $userManager;

    /**
     * CreatePageAction constructor.
     *
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

    public function execute()
    {
        if (!isset($_SESSION['login'])) {
            header('Location: /login');
            exit;
        }

        $url = $_POST['url'];
        $websiteId = $_POST['website_id'];

        $user = $this->userManager->getByLogin($_SESSION['login']);
        $website = $this->websiteManager->getById($websiteId);

        if ($website->getUserId() == $user->getUserId()) {
            if (empty($url)) {
                $_SESSION['flash'] = 'URL cannot be empty!';
            } else {
                if ($this->pageManager->create($website, $url)) {
                    $_SESSION['flash'] = 'URL ' . $url . ' added!';
                }
            }
        }

        header('Location: /website/' . $websiteId);
    }
}