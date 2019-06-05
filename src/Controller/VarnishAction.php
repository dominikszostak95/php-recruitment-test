<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\User;
use Snowdog\DevTest\Model\Varnish;
use Snowdog\DevTest\Model\WebsiteManager;
use Snowdog\DevTest\Model\VarnishManager;

/**
 * Class VarnishAction
 * @package Snowdog\DevTest\Controller
 */
class VarnishAction
{
    /**
     * @var WebsiteManager
     */
    private $websiteManager;

    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * @var User
     */
    private $user;

    /**
     * @var VarnishManager
     */
    private $varnishManager;

    private $websites;
    private $varnishes;

    /**
     * VarnishAction constructor.
     * @param UserManager $userManager
     * @param WebsiteManager $websiteManager
     * @param VarnishManager $varnishManager
     */
    public function __construct(UserManager $userManager, WebsiteManager $websiteManager, VarnishManager $varnishManager)
    {
        $this->websiteManager = $websiteManager;
        $this->userManager = $userManager;
        $this->varnishManager = $varnishManager;
    }

    public function execute()
    {
        if (!isset($_SESSION['login'])) {
            header('Location: /login');
            exit;
        }

        $this->user = $this->userManager->getByLogin($_SESSION['login']);

        require __DIR__ . '/../view/varnish.phtml';
    }

    public function getVarnishes()
    {
        if ($this->user) {
            return $this->varnishManager->getAllByUser($this->user);
        }

        return null;
    }

    public function getWebsites()
    {
        if ($this->user) {
            return $this->websiteManager->getAllByUser($this->user);
        }

        return null;
    }

    public function getAssociatedWebsitesIds(Varnish $varnish)
    {
        $websiteIds = $this->varnishManager->getWebsites($varnish);
        $ids = [];

        foreach ($websiteIds as $websiteId) {
            $ids[] = $websiteId;
        }

        return $ids;
    }
}