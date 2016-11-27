<?php

namespace app\services;

use Predis\Client;
use Slim\Container;

class Session
{
    private $container;
    /** @var $redis Client */
    private $redis;

    /**
     * Session constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->redis = $container->get('redis');
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return unserialize($this->redis->get(session_id()));
    }

    /**
     * @param $value
     */
    public function set($value)
    {
        $this->redis->set(session_id(), serialize($value));
    }

    public function destroy()
    {
        $this->redis->del(session_id());
        session_unset();
        session_destroy();
    }
}