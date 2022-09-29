<?php

namespace src;
include __DIR__ . "/../../config/config.php";

use App\Controllers\UserController;
use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase
{
    private UserController $userController;

    public function setUp(): void
    {
        $this->userController = new UserController();
    }

    public function testAll()
    {
        $this->userController->all();

        self::assertTrue(isset($_GET['users']));
    }

    public function testAdd()
    {
        $_POST["email"] = 'email@gmail.com';
        $_POST["name"] = 'name';
        $_POST["gender"]= 'male';
        $_POST["status"] = 'female';

        $this->userController->add();

        $_SESSION['email_error'] = 'email_error';

        self::assertFalse(isset($_SESSION['email_error']));
    }
}