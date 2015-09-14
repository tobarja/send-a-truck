<?php

require '../vendor/autoload.php';
require '../config.php';

session_cache_limiter(false);
session_start();

$config = array(
    'templates.path' => '../templates',
    'view' => new \Slim\Views\Twig()
);

$app = new \Slim\Slim($config);

$app->container->singleton('db', function () {
    return new \PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
});

require '../src/routes.php';

$app->run();
