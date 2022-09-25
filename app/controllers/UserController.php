<?php

namespace src;
require "../models/impl/User.php";

class UserController
{
    function all(): void
    {
        $_GET['users'] = User::getUsers();
    }

    function add(): void
    {
        if (isset($_POST)) {
            $email = $_POST["email"];
            $name = $_POST["name"];
            $gender = Gender::from($_POST["gender"]);
            $status = Status::from($_POST["status"]);

            User::save(new User($name, $email, $gender, $status));
        }
    }

    function delete(): void
    {
        if (isset($_POST["deleteEmail"])) {
            $email = $_POST["deleteEmail"];
            User::delete($email);
        }
    }
}