<?php

namespace src;
require "../Router.php";

$router = new Router("UserController", "add");
$router->route();

header("Location: user.php");