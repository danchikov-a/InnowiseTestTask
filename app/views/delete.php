<?php

namespace src;
require "../Router.php";

if (isset($_POST['deleteEmail'])) {
    $router = new Router("UserController", "delete");
    $router->route();
}

header("Location: user.php");
