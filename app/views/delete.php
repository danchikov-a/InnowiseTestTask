<?php

namespace App\Views;

use App\Router;

if (isset($_POST['deleteEmail'])) {
    $router = new Router("UserController", "delete");
    $router->route();
}

header("Location: /user");
