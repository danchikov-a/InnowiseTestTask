<?php

$routes = [
    '/' => 'user',
    '/user' => 'user',
];

function getRequestPath(): string
{
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    return '/' . ltrim(str_replace('index.php', '', $path), '/');
}

function getMethod(array $routes, string $path): string
{
    foreach ($routes as $route => $method) {
        if ($path === $route) {
            return $method;
        }
    }

    return 'notFound';
}

function user(): void
{
    include "app/controllers/UserController.php";
}

$path = getRequestPath();
$method = getMethod($routes, $path);
echo $method();