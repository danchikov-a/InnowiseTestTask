<?php

namespace App\Views;

use App\Router;

$router = new Router("UserController", "add");
$router->route();

header("Location: /user");