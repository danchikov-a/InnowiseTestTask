<?php

namespace App;

use App\Api\Impl\UserApi;

class Router
{
    private const CONTROLLER = 0;
    private const ACTION = 1;
    private const CONFIG_PATH = '/config/routes.php';
    private const ID_PARAM = 2;
    private const USER_ID_COOKIE = "userId";
    private const IS_NEED_AUTH = 2;

    private mixed $config;
    private array $routes;

    public function __construct()
    {
        $this->config = require dirname(__DIR__) . self::CONFIG_PATH;
        $this->routes = $this->config['routes'];
    }

    public function run(string $requestUri): void
    {
        $params = array_filter(explode("/", $requestUri));

        if (isset($params[1]) && $params[1] == 'api') {
            if (isset($params[3]) && $params[3] == 'users') {
                $api = new UserApi();
                $api->response();
            } else {
                View::render('app/views/404.php');
            }
        } else {
            if (count($params) == 2) {
                foreach ($this->routes as $name => $value) {
                    if (str_contains($name, '{id}')) {
                        $this->routes[str_replace('{id}', $params[self::ID_PARAM], $name)] = $value;
                        unset($this->routes[$name]);
                    }
                }
            }

            if (isset($this->routes[$requestUri])) {
                $routeAttributes = $this->routes[$requestUri];

                $controllerName = $routeAttributes[self::CONTROLLER];
                $action = $routeAttributes[self::ACTION];

                $class = '\App\Controllers\\' . $controllerName;

                if (class_exists($class) && method_exists($class, $action)) {
                    $controller = new $class;

                    $isAuth = isset($_COOKIE[self::USER_ID_COOKIE]);
                    $isPathNeedAuth = isset($routeAttributes[self::IS_NEED_AUTH]);

                    if ($isPathNeedAuth && !$isAuth) {
                        header("Location: /login");
                    } else if (!$isPathNeedAuth && $isAuth) {
                        header("Location: /");
                    } else {
                        if (count($params) == 2) {
                            $controller->{$action}($params[self::ID_PARAM]);
                        } else {
                            $controller->{$action}();
                        }
                    }
                }
            } else {
                View::render('app/views/404.php');
            }
        }
    }
}