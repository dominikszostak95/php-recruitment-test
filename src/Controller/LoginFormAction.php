<?php

namespace Snowdog\DevTest\Controller;

/**
 * Class LoginFormAction
 * @package Snowdog\DevTest\Controller
 */
class LoginFormAction
{
    public function execute()
    {
        require __DIR__ . '/../view/' . (isset($_SESSION['login']) ? '403' : 'login') . '.phtml';
    }
}