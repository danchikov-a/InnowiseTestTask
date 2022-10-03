<?php

use App\Api\Impl\UserApi;

require_once dirname(__DIR__) . '/vendor/autoload.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$request_url = rtrim(ltrim(urldecode(parse_url($_SERVER['REQUEST_URI'], 5)), '/'), '/');

$params = array_filter(explode("/", $request_url));

//если в url передано 2 параметра
if (count($params) >= 2) {
    if ($params[0] == 'api' && $params[1] == 'users') {
        $action = $params[1];

        $api = new UserApi();
        $api->response();
    } else {
        require_once dirname(__DIR__) . "/" . ('app/views/404.php');
    }
} else if (count($params) < 2) {
    $routes = [
        '/' => 'app/views/user.php',
        '/user' => 'app/views/user.php',
        '/add' => 'app/views/add.php',
        '/delete' => 'app/views/delete.php',
        '/updateForm' => 'app/views/updateForm.php',
        '/update' => 'app/views/update.php'
    ];

    $request_url = $_SERVER['REQUEST_URI'];

    if (isset($routes[$request_url])) {
        require_once dirname(__DIR__) . "/" . $routes[$request_url];
    } else {
        require_once dirname(__DIR__) . "/" . ('app/views/404.php');
    }
} else {
    require_once dirname(__DIR__) . "/" . ('app/views/404.php');
}
