<?php

namespace App;

use App\Api\Impl\UserApi;

class Router
{
    private const CONTROLLER = 0;
    private const ACTION = 1;
    private const CONFIG_PATH = '/config/routes.php';

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
            if (isset($this->routes[$requestUri])) {
                $controllerAndAction = $this->routes[$requestUri];

                $controllerName = $controllerAndAction[self::CONTROLLER];
                $action = $controllerAndAction[self::ACTION];

                $class = '\App\Controllers\\' . $controllerName;

                if (class_exists($class) && method_exists($class, $action)) {
                    $controller = new $class;
                    $controller->{$action}();
                }
            } else {
                View::render('app/views/404.php');
            }
        }
    }
}