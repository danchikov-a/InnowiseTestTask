<?php

use App\Router;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$router = new Router();
$router->run($_SERVER['REQUEST_URI']);

