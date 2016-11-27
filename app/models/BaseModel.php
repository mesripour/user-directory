<?php

namespace app\models;

use \Illuminate\Database\Capsule\Manager;
use Slim\Container;
use Elasticsearch\Client;

class BaseModel
{
    protected $container;

    /**
     * BaseModel constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return Manager
     */
    protected function mysql(): Manager
    {
        return $this->container->get('mysql');
    }

    /**
     * @return Client
     */
    protected function elastic(): Client
    {
        return $this->container->get('elastic');
    }
}