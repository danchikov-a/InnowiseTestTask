<?php

namespace App\Controllers;

use App\Enums\Gender;
use App\Enums\Status;
use App\Models\Impl\User;
use App\Response;
use App\Session;
use App\Validator\UserValidator;
use App\View;

class UserController
{
    private User $user;
    private UserValidator $validator;
    private Response $response;
    private Session $session;

    public function __construct()
    {
        $this->user = new User();
        $this->validator = new UserValidator();
        $this->response = new Response();
        $this->session = new Session();
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
        $postParams = [
            'name' => $_POST["name"],
            'email' => $_POST["email"],
            'gender' => $_POST["gender"],
            'status' => $_POST["status"] ?? Status::ACTIVE->value,
            'password' => $_POST["password"] ?? ""
        ];

        if ($this->validator->isValidUser($postParams)) {
            $this->user->store($postParams);
            $this->session->unsetValidationError("email_error");
            $this->response->sendResponse(200, "/");
        } else {
            $errors = $this->validator->getErrors();
            $this->session->setValidationError("email_error", $errors["email"]);
            $this->response->sendResponse(409, "/");
        }

        $this->response->redirect("/");
    }

    public function delete(int $id): void
    {
        if ($this->user->destroy($id)) {
            $this->response->sendResponse(200, "/");
        } else {
            $this->response->sendResponse(409, "/");
        }

        $this->response->redirect("/");
    }

    public function update(int $id): void
    {
        $putParams = [
            'name' => $_POST["name"],
            'email' => $_POST["email"],
            'gender' => $_POST["gender"],
            'status' => $_POST["status"],
            'id' => $id,
        ];

        if ($this->validator->isValidUser($putParams)) {
            $this->user->update($putParams);
            $this->session->unsetValidationError("email_error");
            $this->response->sendResponse(200, "/");
        } else {
            $errors = $this->validator->getErrors();
            $this->session->setValidationError("email_error", $errors["email"]);
            $this->response->sendResponse(409, "/");
        }

        $this->response->redirect("/");
    }

    /*public function checkUser(): void
    {
        $postParams = ['name' => $_POST["name"], 'email' => $_POST["email"], 'password' => $_POST["password"]];

        CheckAuthUser::handle($postParams);
    }

    public function logout(): void
    {
        setcookie(self::USER_NAME_COOKIE, "", time() - self::COOKIE_LIFETIME);
        header("Location: /login");
    }*/
}