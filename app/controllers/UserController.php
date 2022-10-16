<?php

namespace App\Controllers;

use App\Enums\Gender;
use App\Enums\Status;
use App\Models\Impl\BlockingInformationLogger;
use App\Models\Impl\User;
use App\Models\Impl\UserSessionInformation;
use App\View;

class UserController
{
    private const COOKIE_LIFETIME = 3600;
    private const LOGIN_ATTEMPTS = 3;
    private const USERNAME_COOKIE = "userName";

    public function all(): void
    {
        if (!isset($_COOKIE[self::USERNAME_COOKIE])) {
            header("Location: /login");
        }

        $_GET["users"] = User::getUsers();

        View::render('app/views/user.php');
    }

    public function showUpdate(): void
    {
        View::render('app/views/updateForm.php');
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
        if (!isset($_COOKIE[self::USERNAME_COOKIE])) {
            header("Location: /login");
        }

        View::render('app/views/welcome.php');
    }

    public function add(): void
    {
        if (isset($_POST)) {
            $email = $_POST["email"];
            $name = $_POST["name"];
            $gender = Gender::from($_POST["gender"]);
            $status = isset($_POST["status"]) ? Status::from($_POST["status"]) : Status::ACTIVE;
            $password = $_POST["password"];

            if (User::save(new User($name, $email, $gender, $status, $password))) {
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

            if (User::update($oldEmail, new User($name, $email, $gender, $status, ""))) {
                unset($_SESSION["email_error"]);
            } else {
                $_SESSION["email_error"] = true;
            }
        }

        header("Location: /");
    }

    public function checkUser(): void
    {
        if (isset($_POST)) {
            $name = $_POST["name"];
            $email = $_POST["email"];
            $password = $_POST["password"];

            if (User::checkUser($name, $email, $password)) {
                unset($_SESSION['loginError']);
                setcookie("userName", $name, time() + self::COOKIE_LIFETIME);
                header("Location: /welcome");
            } else {
                $_SESSION['loginError'] = true;
                $ip = $_SERVER['REMOTE_ADDR'];

                if (isset($_SESSION[$ip])) {
                    $userSessionInformation = $_SESSION[$ip];

                    if ($userSessionInformation->getAttempts() == self::LOGIN_ATTEMPTS - 1) {
                        $_SESSION['authenticateError'] = true;
                        $blockTime = time();

                        $userSessionInformation->setBlockTime($blockTime);

                        $logMessage = sprintf("%s %s %s", $ip, date('m/d/Y H:i:s', $blockTime),
                            date('m/d/Y H:i:s', $userSessionInformation::BLOCK_DURATION + $blockTime));

                        BlockingInformationLogger::writeLog($logMessage);
                    } else {
                        $userSessionInformation->addAttempt();
                    }
                } else {
                    $userSessionInformation = new UserSessionInformation();

                    $userSessionInformation->setIp($ip);
                    $userSessionInformation->setAttempts(1);
                }

                $_SESSION[$ip] = $userSessionInformation;

                header("Location: /login");
            }
        }
    }

    public function logout(): void
    {
        setcookie("userName", "", time() - self::COOKIE_LIFETIME);
        header("Location: /login");
    }
}