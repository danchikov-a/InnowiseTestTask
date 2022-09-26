<?php

namespace src;
require "app/Router.php";

$router = new Router("UserController", "add");
$router->route();

header("Location: /user");