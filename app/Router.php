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

                call_user_func_array([new $controller, $action], $this->params);
            }
        } else {
            View::render('app/views/404.php');
        }
    }

    private function changeRoutes(array $params): void
    {
        foreach ($this->routes as $requestMethod => $route) {
            foreach ($route as $url => $controllerAndAction) {
                $currentUrlParams = array_filter(explode("/", $url));

                if (count($currentUrlParams) == count($params) && $_SERVER["REQUEST_METHOD"] == $requestMethod) {
                    foreach ($currentUrlParams as $index => $currentUrlParam) {
                        if (preg_match("/\{\w+?}/", $currentUrlParam)) {
                            $currentUrlParams[$index] = $params[$index];
                            $this->params[$index] = $params[$index];
                        }
                    }

                    $url = "/" . implode("/", $currentUrlParams);
                    $this->routes[$requestMethod][$url] = $controllerAndAction;

                    unset($this->routes[$url]);
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