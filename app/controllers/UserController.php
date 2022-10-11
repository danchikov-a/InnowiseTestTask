<?php

namespace App\Controllers;

use App\Enums\Gender;
use App\Enums\Status;
use App\Models\Impl\User;
use App\View;

class UserController
{
    public function all(): void
    {
        $_GET["users"] = User::getUsers();

        View::render('app/views/user.php');
    }

    public function showUpdate(): void
    {
        View::render('app/views/updateForm.php');
    }

    public function add(): void
    {
        if (isset($_POST)) {
            $email = $_POST["email"];
            $name = $_POST["name"];
            $gender = Gender::from($_POST["gender"]);
            $status = Status::from($_POST["status"]);

            if (User::save(new User($name, $email, $gender, $status))) {
                unset($_SESSION["email_error"]);
            } else {
                $_SESSION["email_error"] = true;
            }
        }

        header("Location: /");
    }

    public function delete(): void
    {
        if (isset($_POST["deleteEmail"])) {
            $email = $_POST["deleteEmail"];
            User::delete($email);
        }

        header("Location: /");
    }

    public function update(): void
    {
        if (isset($_POST)) {
            $oldEmail = $_POST["oldEmail"];

            $name = $_POST["name"];
            $email = $_POST["email"];
            $gender = Gender::from($_POST["gender"]);
            $status = Status::from($_POST["status"]);

            if (User::update($oldEmail, new User($name, $email, $gender, $status))) {
                unset($_SESSION["email_error"]);
            } else {
                $_SESSION["email_error"] = true;
            }
        }

        header("Location: /");
    }
}