<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\Varnish;
use Snowdog\DevTest\Model\VarnishManager;
use Snowdog\DevTest\Model\Website;

/**
 * Class CreateVarnishLinkAction
 *
 * @package Snowdog\DevTest\Controller
 */
class CreateVarnishLinkAction
{
    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * @var VarnishManager
     */
    private $varnishManager;

    /**
     * CreateVarnishLinkAction constructor.
     *
     * @param UserManager $userManager
     * @param VarnishManager $varnishManager
     */
    public function __construct(UserManager $userManager, VarnishManager $varnishManager)
    {
        $this->userManager = $userManager;
        $this->varnishManager = $varnishManager;
    }

    public function execute()
    {
        if (!isset($_SESSION['login'])) {
            header('Location: /login');
            exit;
        }

        $varnishId = $_POST['varnishId'];
        $websiteId = $_POST['websiteId'];

        try {
            $this->varnishManager->link($varnishId, $websiteId);
            $message = 'Website successfully linked to varnish.';
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        $response = [
            'message' => $message
        ];

        echo json_encode($response);
    }
}