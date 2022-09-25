<?php

namespace src;
require $_SERVER['DOCUMENT_ROOT'] . "/app/controllers/UserController.php";

class Router
{
    private string $controller;
    private string $action;

    /**
     * @param string $controller
     * @param string $action
     */
    public function __construct(string $controller, string $action)
    {
        $this->controller = $controller;
        $this->action = $action;
    }

    public function route(): void
    {
        //  $controller = new $this->controller();
        $controller = new UserController();
        $controller->{$this->action}();
    }
}