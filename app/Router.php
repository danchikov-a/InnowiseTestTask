<?php

namespace App;

class Router
{
    private const CONTROLLER = 0;
    private const ACTION = 1;
    private const MIDDLEWARE = 2;
    private const CONFIG_ROUTES_PATH = '/config/routes.php';

    private array $routes;

    private array $params = [];

    public function __construct()
    {
        $this->routes = require dirname(__DIR__) . self::CONFIG_ROUTES_PATH;
    }

    public function run(string $requestUri): void
    {
        $params = array_filter(explode("/", $requestUri));

        $this->changeRoutes($params);
        $route = $this->isThereSuchRoute($requestUri);

        if ($route) {
            $class = $route[self::CONTROLLER];
            $action = $route[self::ACTION];

            if (class_exists($class) && method_exists($class, $action)) {
                $controller = new $class;

                if (isset($route[self::MIDDLEWARE])) {
                    foreach ($route[self::MIDDLEWARE] as $middlewareClass) {
                        $middlewareClass = new $middlewareClass;
                        $middlewareClass->handle($requestUri);
                    }
                }

                if (count($this->params) == 0) {
                    $controller->{$action}();
                } else {
                    $controller->{$action}($this->params["id"]);
                }
            }
        } else {
            View::render('app/views/404.php');
        }
    }

    private function changeRoutes(array $params): void
    {
        $idParam = 0;

        foreach ($params as $index => $param) {
            if (is_numeric($param)) {
                $idParam = $index;
            }
        }

        foreach ($this->routes as $requestMethod => $route) {
            foreach ($route as $url => $controllerAndAction) {
                if (str_contains($url, '{id}')) {
                    if (isset($params[$idParam])) {
                        $this->params["id"] = $params[$idParam];
                        $url = str_replace('{id}', $params[$idParam], $url);
                        $this->routes[$requestMethod][$url] = $controllerAndAction;

                        unset($this->routes[$url]);
                    }
                }
            }
        }
    }

    private function isThereSuchRoute(string $requestUri): array|false
    {
        foreach ($this->routes as $requestMethod => $route) {
            foreach ($route as $url => $controllerAndAction) {
                if ($requestUri == $url && $_SERVER["REQUEST_METHOD"] == $requestMethod) {
                    return $this->routes[$requestMethod][$url];
                }
            }
        }

        return false;
    }
}