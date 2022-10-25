<?php

namespace App\Controllers;

use App\Enums\Status;
use App\Models\Impl\User;
use App\Models\Impl\UserSessionInformation;
use App\Validator\UserValidator;
use App\View;

class UserController extends BaseController
{
    private User $user;
    private UserValidator $validator;
    private UserSessionInformation $userSessionInformation;
    private const BLOCK_DURATION = 10;

    public function __construct()
    {
        parent::__construct();
        $this->user = new User();
        $this->validator = new UserValidator();
        $this->userSessionInformation = new UserSessionInformation();
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
        $userSessionInformation = $this->userSessionInformation->getByIp($_SERVER["REMOTE_ADDR"]);

        if ($userSessionInformation) {
            if ($userSessionInformation->getBlockTime() + self::BLOCK_DURATION < time()) {
                $this->session->unsetValidationError('authenticateError');
            } else {
                $this->session->setValidationError('authenticateError', "authentication error");
            }
        } else {
            $this->session->unsetValidationError('authenticateError');
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
}