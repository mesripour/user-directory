<?php

$container = $app->getContainer();

$container['renderer'] = function ($container) {
    $settings = $container->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

$container['logger'] = function ($container) {
    $settings = $container->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$container['mysql'] = function ($container) {
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container['settings']['mysql']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    return $capsule;
};

$container['redis'] = function ($container) {
    /** @var  $container \Slim\Container*/
    $settings = $container->get('settings')['redis'];
    $connection = new \Predis\Client([
        'scheme' => $settings['schema'],
        'host'   => $settings['host'],
        'port'   => $settings['port'],
        'database' => $settings['defaultDb']
    ]);
    return $connection;
};

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('../templates/', [
//        'cache' => 'templates/cache/',
        'cache' => false
    ]);
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));
    return $view;
};

$container['session'] = function ($container) {
    return new \app\services\Session($container);
};

$container['userModel'] = function ($container) {
    return new \app\models\UserModel($container);
};

$container['friendModel'] = function ($container) {
    return new \app\models\FriendModel($container);
};

$container['searchModel'] = function ($container) {
    return new \app\models\SearchModel($container);
};

$container['elastic'] = function () {
    return Elasticsearch\ClientBuilder::create()->build();
};

$container['memcached'] = function () {
    $mem = new \Memcached();
    $mem->addServer("127.0.0.1", 11211);
    return $mem;
};