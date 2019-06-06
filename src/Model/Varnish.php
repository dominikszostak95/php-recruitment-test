<?php

namespace Snowdog\DevTest\Model;

/**
 * Class Website
 *
 * @package Snowdog\DevTest\Model
 */
class Varnish
{
    /**
     * @var int
     */
    public $user_id;

    /**
     * @var int
     */
    public $varnish_id;

    public $ip;

    /**
     * Website constructor.
     */
    public function __construct()
    {
        $this->user_id = intval($this->user_id);
        $this->varnish_id = intval($this->varnish_id);
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return int
     */
    public function getVarnishId()
    {
        return $this->varnish_id;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }
}