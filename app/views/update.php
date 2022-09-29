<?php

namespace App\Views;

use App\Router;

if (isset($_POST)) {
    $router = new Router("UserController", "update");
    $router->route();
}
header("Location: /user");