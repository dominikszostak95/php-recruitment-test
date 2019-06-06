<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\VarnishManager;

/**
 * Class CreateWebsiteAction
 *
 * @package Snowdog\DevTest\Controller
 */
class CreateVarnishAction
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
     * CreateVarnishAction constructor.
     *
     * @param UserManager $userManager
     * @param VarnishManager $varnishManager
     */
    public function __construct(UserManager $userManager, VarnishManager $varnishManager)
    {
        $this->userManager = $userManager;
        $this->varnishManager = $varnishManager;

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

        $ip = $_POST['ip'];

        if (empty($ip)) {
            $_SESSION['flash'] = 'IP cannot be empty!';
        } elseif ($this->varnishManager->create($this->user, $ip)) {
            $_SESSION['flash'] = 'Varnish Server ' . $ip . ' added!';
        }


        header('Location: /varnish');
    }
}