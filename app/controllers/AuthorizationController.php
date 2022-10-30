<?php

namespace App\Controllers;

use App\Models\Impl\User;
use App\Validator\UserValidator;

class AuthorizationController extends BaseController
{
    private const USER_NAME_COOKIE = "userName";

    private User $user;
    private UserValidator $validator;

    public function __construct()
    {
        parent::__construct();
        $this->user = new User();
        $this->validator = new UserValidator();
    }

    public function checkUser(): void
    {
        $postParams = ['name' => $_POST["name"], 'email' => $_POST["email"], 'password' => $_POST["password"]];

        if ($this->user->isUserEnteredRightCredentials($postParams)) {
            $this->session->unsetError("loginError");

            $this->cookie->setCookie(self::USER_NAME_COOKIE, $_POST["name"]);
            $this->cookie->setCookie("userId", $this->user->getIdByEmail($_POST["email"]));

            $this->response->sendResponse(200, "/welcome");
            $this->response->redirect("/welcome");
        } else {
            $this->session->setValue("loginError", "Wrong credentials");

            $this->response->sendResponse(401, "/login");
            $this->response->redirect("/block");
        }
    }

    public function logout(): void
    {
        $this->cookie->unsetCookie(self::USER_NAME_COOKIE);

        $this->response->sendResponse(200, "/login");
        $this->response->redirect("/login");
    }
}