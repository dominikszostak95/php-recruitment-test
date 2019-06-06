<?php

namespace Snowdog\DevTest\Controller;

/**
 * Class SitemapImportAction
 *
 * @package Snowdog\DevTest\Controller
 */
class SitemapImportAction
{
    public function execute()
    {
        if (!isset($_SESSION['login'])) {
            header('Location: /login');
            exit;
        }

        include __DIR__ . '/../view/sitemap_import.phtml';
    }
}