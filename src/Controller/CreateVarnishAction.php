<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\VarnishManager;

/**
 * Class CreateWebsiteAction
 * @package Snowdog\DevTest\Controller
 */
class CreateVarnishAction
{
    /**
     * @var UserManager
     */
    private $userManager;

    private $varnishManager;

    /**
     * CreateVarnishAction constructor.
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

        $ip = $_POST['ip'];
        $user = $this->userManager->getByLogin($_SESSION['login']);

        if ($user) {
            if ($this->varnishManager->create($user, $ip)) {
                $_SESSION['flash'] = 'Varnish ' . $ip . ' added!';
            }
        } else {
            $_SESSION['flash'] = 'IP cannot be empty!';
        }

        header('Location: /varnish');
    }
}