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
        session_start();

        if (isset($_POST)) {
            $email = $_POST["email"];
            $name = $_POST["name"];
            $gender = Gender::from($_POST["gender"]);
            $status = Status::from($_POST["status"]);

            if (User::save(new User($name, $email, $gender, $status))) {
                unset($_SESSION['email_error']);
            } else {
                $_SESSION['email_error'] = true;
            }
        }
    }

    function delete(): void
    {
        if (isset($_POST["deleteEmail"])) {
            $email = $_POST["deleteEmail"];
            User::delete($email);
        }
    }

    function update(): void
    {
        session_start();

        if (isset($_POST)) {
            $oldEmail = $_POST["oldEmail"];

            $name = $_POST["name"];
            $email = $_POST["email"];
            $gender = Gender::from($_POST["gender"]);
            $status = Status::from($_POST["status"]);

            if (User::update($oldEmail, new User($name, $email, $gender, $status))) {
                unset($_SESSION['email_error']);
            } else {
                $_SESSION['email_error'] = true;
            }
        }
    }
}