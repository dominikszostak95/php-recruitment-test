<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\SitemapImportManager;
use Snowdog\DevTest\Model\UserManager;

/**
 * Class SitemapImportAction
 *
 * @package Snowdog\DevTest\Controller
 */
class SitemapImportPostAction
{
    /**
     * @var SitemapImportManager
     */
    private $sitemapImportManager;

    /**
     * @var UserManager
     */
    private $userManager;

    public function __construct(SitemapImportManager $sitemapImportManager, UserManager $userManager)
    {
        $this->sitemapImportManager = $sitemapImportManager;
        $this->userManager = $userManager;

        if (isset($_SESSION['login'])) {
            $this->user = $userManager->getByLogin($_SESSION['login']);
        }
    }

    public function execute()
    {
        $siteMap = $_FILES['sitemap'];
        $this->sitemapImportManager->import($siteMap, $this->user);
    }
}