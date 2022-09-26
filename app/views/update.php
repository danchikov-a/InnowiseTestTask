<?php

namespace src;
require "app/Router.php";

if (isset($_POST)) {
    $router = new Router("UserController", "update");
    $router->route();
}
header("Location: /user");