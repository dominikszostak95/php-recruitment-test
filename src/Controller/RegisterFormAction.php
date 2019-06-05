<?php

namespace Snowdog\DevTest\Controller;

/**
 * Class RegisterFormAction
 * @package Snowdog\DevTest\Controller
 */
class RegisterFormAction
{
    public function execute() {
        require __DIR__ . '/../view/' . (isset($_SESSION['login']) ? '403' : 'register') . '.phtml';
    }
}