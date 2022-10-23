<?php

namespace App;

class Router
{
    private const CONTROLLER = 0;
    private const ACTION = 1;
    private const CONFIG_PATH = '/config/routes.php';
    private const ID_PARAM = 2;

    private mixed $config;
    private array $routes;

    private array $params = [];

    public function __construct()
    {
        $this->config = require dirname(__DIR__) . self::CONFIG_PATH;
        $this->routes = $this->config;
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
        foreach ($this->routes as $requestMethod => $route) {
            foreach ($route as $url => $controllerAndAction) {
                if (str_contains($url, '{id}')) {
                    if (isset($params[self::ID_PARAM])) {
                        $this->params["id"] = $params[self::ID_PARAM];

                        $url = str_replace('{id}', $params[self::ID_PARAM], $url);
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
                if ($requestUri == $url) {
                    return $this->routes[$requestMethod][$url];
                }
            }
        }

        return false;
    }
}