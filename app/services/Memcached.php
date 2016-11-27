<?php

namespace app\services;

use Slim\Container;

class Memcached
{
    private $container;
    /** @var $redis \Memcached */
    private $memcached;

    /**
     * Session constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->memcached = $container->get('memcached');
    }

    /**
     * get memcached
     *
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        return $this->memcached->get($key);
    }

    /**
     * set memcached
     *
     * @param string $key
     * @param mixed $value
     */
    public function set(string $key, mixed $value)
    {
        $this->memcached->set($key, $value);
    }
}