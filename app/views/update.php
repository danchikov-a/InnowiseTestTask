<?php

namespace src;
require "../Router.php";

if (isset($_POST)) {
    $router = new Router("UserController", "update");
    $router->route();
}
header("Location: updateForm.php");