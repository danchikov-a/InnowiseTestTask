<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

session_start();
$request_url = rtrim(ltrim(urldecode(parse_url($_SERVER['REQUEST_URI'], 5)), '/'), '/');

$params = array_filter(explode("/", $request_url));
//если в url передано 2 параметра
if (count($params) == 2) {
    $dynamic_routes = [
        'offers' => 'pages/offer.php',
    ];
    if (isset($dynamic_routes[$params[0]])) {
        $get = $params[1];
        require_once $dynamic_routes[$params[0]];
    } else {
        require_once('pages/404.php');
    }
} else if (count($params) < 2) {
    $routes = [
        '/' => 'app/views/user.php',
        '/user' => 'app/views/user.php',
        '/add' => 'app/views/add.php',
        '/delete' => 'app/views/delete.php',
        '/updateForm' => 'app/views/updateForm.php',
        '/update' => 'app/views/update.php',
        '/user.css' => 'css/user.css'
    ];

    $request_url = $_SERVER['REQUEST_URI'];

    if (isset($routes[$request_url])) {
        require_once $routes[$request_url];
    } else {
        require_once('app/views/404.php');
    }
} else {
    require_once('app/views/404.php');
}
?>
<style><?php include 'node_modules/bootstrap/dist/css/bootstrap.min.css'; ?></style>
<style><?php include 'css/user.css'; ?></style>
<script><?php include 'public/js/confirm-delete.js'; ?></script>