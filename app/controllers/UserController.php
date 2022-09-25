<?php

namespace src;
require_once "app/models/impl/User.php";

/*class UserController
{
    private User $user;

    public function showUsers(): void
    {
        $users = $this->user->getUsers();
        $_GET['users'] = $users;

        include "app/views/user.php";
    }
}*/
$user = new User();
$users = $user->getUsers();

$_GET['users'] = $users;

include "app/views/user.php";