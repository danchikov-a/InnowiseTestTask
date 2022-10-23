<?php

namespace App\Controllers;

use App\Enums\Gender;
use App\Enums\Status;
use App\Models\Impl\User;
use App\Validator\UserValidator;
use App\View;

class UserController
{
    private const COOKIE_LIFETIME = 3600;
    private const USER_NAME_COOKIE = "userName";

    private User $user;
    private UserValidator $validator;

    public function __construct()
    {
        $this->user = new User();
        $this->validator = new UserValidator();
    }

    public function all(): void
    {
        $users = $this->user->showAll();

        View::render('app/views/user.php', ['users' => $users]);
    }

    public function showUpdate(int $id): void
    {
        $userById = $this->user->index($id);

        View::render('app/views/updateForm.php', ['user' => $userById]);
    }

    public function showRegistration(): void
    {
        View::render('app/views/registrationForm.php');
    }

    public function showLogin(): void
    {
        if (isset($_SESSION['authenticateError'])) {
            $userSessionInformation = $_SESSION[$_SERVER["REMOTE_ADDR"]];

            if ($userSessionInformation->checkBlockTime()) {
                unset($_SESSION[$_SERVER["REMOTE_ADDR"]]);
                unset($_SESSION['authenticateError']);
            }
        }

        View::render('app/views/loginForm.php');
    }

    public function showWelcome(): void
    {
        View::render('app/views/welcome.php');
    }

    public function add(): void
    {
        if (isset($_POST)) {
            $postParams = [
                'name' => $_POST["name"],
                'email' => $_POST["email"],
                'gender' => $_POST["gender"],
                'status' => $_POST["status"] ?? Status::ACTIVE->value,
                'password' => $_POST["password"] ?? ""
            ];

            if ($this->validator->isValidUser($postParams)) {
                $this->user->store($postParams);
                unset($_SESSION["email_error"]);
            } else {
                $errors = $this->validator->getErrors();
                $_SESSION["email_error"] = $errors["email"];
            }
        }

        header("Location: /");
    }

    public function delete(int $id): void
    {
        $this->user->destroy($id);

        header("Location: /");
    }

    public function update(int $id): void
    {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $gender = $_POST["gender"];
        $status = $_POST["status"];

        if ($this->user->update(['name' => $name, 'email' => $email, 'gender' => $gender, 'status' => $status, 'id' => $id])) {
            unset($_SESSION["email_error"]);
        } else {
            $_SESSION["email_error"] = true;
        }

        header("Location: /");
    }

    public function checkUser(): void
    {
        if (isset($_POST)) {
            $name = $_POST["name"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $user = new User($name, $email, Gender::MALE, Status::ACTIVE, $password);

            if ($user->checkUser()) {
                unset($_SESSION['loginError']);
                setcookie(self::USER_NAME_COOKIE, $user->getName(), time() + self::COOKIE_LIFETIME);
                header("Location: /welcome");
            } else {
                $_SESSION['loginError'] = true;
                header("Location: /block");
            }
        }
    }

    public function logout(): void
    {
        setcookie(self::USER_NAME_COOKIE, "", time() - self::COOKIE_LIFETIME);
        header("Location: /login");
    }
}