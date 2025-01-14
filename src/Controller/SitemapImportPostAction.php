<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\SitemapImportManager;
use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\User;

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

    /**
     * @var User
     */
    private $user;

    /**
     * SitemapImportPostAction constructor.
     *
     * @param SitemapImportManager $sitemapImportManager
     * @param UserManager $userManager
     */
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
        if (!$this->user) {
            header('Location: /login');
            exit;
        }

        $siteMap = $_FILES['sitemap'];

        try {
            $import = $this->sitemapImportManager->import($siteMap, $this->user);

            if ($import) {
                $_SESSION['flash'] = 'Sitemap successfully imported!';
            } else {
                $_SESSION['flash'] = 'Something went wrong. Please try again later.';
            }
        } catch (\Exception $e) {
            $_SESSION['flash'] = $e->getMessage();
        }

        header('Location: /');
    }
}