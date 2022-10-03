<?php

namespace App\Api\Impl;

use App\Api\Api;
use App\Enums\Gender;
use App\Enums\Status;
use App\Models\Impl\User;

class UserApi extends Api
{
    protected function methodGet(): void
    {
        if (isset($this->uriParts[self::CERTAIN_EMAIL_PARAM])) {
            $user = User::getUser($this->uriParts[self::CERTAIN_EMAIL_PARAM]);

            if (!$user) {
                http_response_code(404);
                echo "There isn't user with such email";
            } else {
                http_response_code(200);
                echo json_encode($user, JSON_PRETTY_PRINT);
            }
        } else {
            echo json_encode(User::getUsers(), JSON_PRETTY_PRINT);
        }
    }

    protected function methodPost(): void
    {
        if (count($this->uriParts) == 2) {
            if (isset($_POST["email"]) && isset($_POST["name"]) && isset($_POST["gender"]) && isset($_POST["status"])) {
                $email = $_POST["email"];
                $name = $_POST["name"];
                $gender = Gender::from($_POST["gender"]);
                $status = Status::from($_POST["status"]);

                if (User::save(new User($name, $email, $gender, $status))) {
                    http_response_code(200);
                    echo "User saved";
                } else {
                    http_response_code(404);
                    echo "There is user with such email";
                }
            } else {
                http_response_code(422);
                echo "Parameters not set";
            }
        } else {
            http_response_code(400);
            echo "Uri have to consists of two parts";
        }
    }

    protected function methodDelete(): void
    {
        if (count($this->uriParts) == 3) {
            $email = $this->uriParts[self::CERTAIN_EMAIL_PARAM];

            if (User::delete($email)) {
                http_response_code(200);
                echo "User deleted";
            } else {
                http_response_code(404);
                echo "There isn't user with such email";
            }
        } else {
            http_response_code(400);
            echo "Uri have to consists of three parts";
        }
    }

    protected function methodPut(): void
    {
        if (count($this->uriParts) == 3) {
            //TODO PUT parsing

            parse_str(file_get_contents("php://input"),$post_vars);
            print_r($post_vars);

            if (isset($_PUT["email"]) && isset($_PUT["name"]) && isset($_PUT["gender"]) && isset($_PUT["status"])) {
                $oldEmail = $this->uriParts[self::CERTAIN_EMAIL_PARAM];
                $email = $_POST["email"];
                $name = $_POST["name"];
                $gender = Gender::from($_POST["gender"]);
                $status = Status::from($_POST["status"]);

                if (User::update($oldEmail, new User($name, $email, $gender, $status))) {
                    http_response_code(200);
                    echo "User updated";
                } else {
                    http_response_code(404);
                    echo "There isn't user with such email";
                }
            } else {
                http_response_code(422);
                echo "Parameters not set";
            }
        } else {
            http_response_code(400);
            echo "Uri have to consists of three parts";
        }
    }
}