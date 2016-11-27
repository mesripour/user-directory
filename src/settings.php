<?php

return [
    'settings' => [
        'displayErrorDetails' => false, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => '<host>',
            'database' => 'directory',
            'username' => '<username>',
            'password' => '<password>',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ],

        'redis' => [
            'schema' => 'tcp',
            'host' => '<host>',
            'port' => 6379,
            'defaultDb' => 1,
        ],
    ],
];
