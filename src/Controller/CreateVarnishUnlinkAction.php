<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\Varnish;
use Snowdog\DevTest\Model\VarnishManager;
use Snowdog\DevTest\Model\Website;

class CreateVarnishUnlinkAction
{
    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * @var VarnishManager
     */
    private $varnishManager;

    public function __construct(UserManager $userManager, VarnishManager $varnishManager)
    {
        $this->userManager = $userManager;
        $this->varnishManager = $varnishManager;
    }

    public function execute()
    {
        $varnishId = $_POST['varnishId'];
        $websiteId = $_POST['websiteId'];

        try {
            $this->varnishManager->unlink($varnishId, $websiteId);
            $message = 'Website successfully unlinked from varnish.';
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        $response = [
            'message' => $message,
        ];

        echo json_encode($response);
    }
}