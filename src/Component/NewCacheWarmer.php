<?php

namespace Snowdog\DevTest\Component;

use Old_Legacy_CacheWarmer_Warmer;
use Old_Legacy_CacheWarmer_Actor;

class NewCacheWarmer extends Old_Legacy_CacheWarmer_Warmer
{
    /** @var Old_Legacy_CacheWarmer_Actor */
    private $actor;


    /** @var string */
    private $hostname;

    /** @var string */
    private $ip;

    /**
     * @param Old_Legacy_CacheWarmer_Actor $actor
     */
    public function setActor($actor)
    {
        $this->actor = $actor;
    }

    /**
     * @param string $hostname
     */
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;
    }

    /**
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    public function warm($url) {
        sleep(1); // this emulates visit to http://$hostname/$url via $ip
        $this->actor->act($this->hostname, $this->ip, $url);
    }
}