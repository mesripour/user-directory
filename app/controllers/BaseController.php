<?php

namespace app\controllers;

use app\models\{FriendModel, SearchModel};
use app\services\Session;
use Psr\Container\ContainerInterface;
use app\models\UserModel;
use Slim\Http\{Request, Response};
use Slim\Views\Twig;

class BaseController
{
    protected $container;
    /** @var Request */
    protected $request;
    /** @var Response */
    protected $response;
    /** @var Twig */
    protected $view;
    protected $userId;


    /**
     * BaseController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->request = $container->get('request');
        $this->response = $container->get('response');
        $this->view = $container->get('view');
        $this->userId = $container->get('session')->get()['userId'];
    }

    /**
     * @return UserModel
     */
    protected function userModel(): UserModel
    {
        return $this->container->get('userModel');
    }

    /**
     * @return FriendModel
     */
    protected function friendModel(): FriendModel
    {
        return $this->container->get('friendModel');
    }

    /**
     * @return SearchModel
     */
    protected function searchModel(): SearchModel
    {
        return $this->container->get('searchModel');
    }

    /**
     * @return Session
     */
    protected function session(): Session
    {
        return $this->container->get('session');
    }

    /**
     * @return \Memcached
     */
    protected function memcached(): \Memcached
    {
        return $this->container->get('memcached');
    }
}