<?php

use App\Api\Impl\UserApi;

require_once dirname(__DIR__) . '/vendor/autoload.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$request_url = $_SERVER['REQUEST_URI'];

$params = array_filter(explode("/", $request_url));

if (isset($params[1]) && isset($params[2])) {
    if ($params[1] == 'api' && $params[2] == 'users') {
        $action = $params[1];

        $api = new UserApi();
        $api->response();
    } else {
        require_once dirname(__DIR__) . "/" . ('app/views/404.php');
    }
} else {
    $routes = [
        '/' => 'app/views/user.php',
        '/user' => 'app/views/user.php',
        '/updateForm' => 'app/views/updateForm.php',
    ];

    $controllerName = $_GET['controller'] ?? 'UserController';
    $action = $_GET['action'] ?? 'all';
    $class = '\App\Controllers\\' . $controllerName;

    if (class_exists($class) && method_exists($class, $action)) {
        $controller = new $class;
        $controller->{$action}();
    }

    if (isset($routes[$request_url])) {
        require_once dirname(__DIR__) . "/" . $routes[$request_url];
    } else {
        require_once dirname(__DIR__) . "/" . ('app/views/404.php');
    }
}
