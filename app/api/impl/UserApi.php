<?php

namespace App\Api\Impl;

use App\Api\AbstractApi;
use App\Enums\Gender;
use App\Enums\Status;
use App\Models\Impl\User;

class UserApi extends AbstractApi
{
    protected function get(): void
    {
        if (isset($this->uriParts[self::CERTAIN_EMAIL_PARAM])) {
            $user = User::getUser($this->uriParts[self::CERTAIN_EMAIL_PARAM]);

            if (!$user) {
                http_response_code(404);
                echo $this->messages['userDoesntExistMessage'];
            } else {
                http_response_code(200);
                echo json_encode($user, JSON_PRETTY_PRINT);
            }
        } else {
            echo json_encode(User::getUsers(), JSON_PRETTY_PRINT);
        }
    }

    protected function post(): void
    {
        if (count($this->uriParts) == 2) {
            if (isset($_POST["email"]) && isset($_POST["name"]) && isset($_POST["gender"]) && isset($_POST["status"])) {
                $email = $_POST["email"];
                $name = $_POST["name"];
                $gender = Gender::from($_POST["gender"]);
                $status = Status::from($_POST["status"]);

                if (User::save(new User($name, $email, $gender, $status))) {
                    http_response_code(200);
                    echo $this->messages['userSavedMessage'];
                } else {
                    http_response_code(404);
                    echo $this->messages['userExistsMessage'];
                }
            } else {
                http_response_code(422);
                echo $this->messages['paramsNotSetMessage'];
            }
        } else {
            http_response_code(400);
            echo $this->messages['notValidTwoPartsUriMessage'];
        }
    }

    protected function delete(): void
    {
        if (count($this->uriParts) == 3) {
            $email = $this->uriParts[self::CERTAIN_EMAIL_PARAM];

            if (User::delete($email)) {
                http_response_code(200);
                echo $this->messages['userDeletedMessage'];
            } else {
                http_response_code(404);
                echo $this->messages['userDoesntExistMessage'];
            }
        } else {
            http_response_code(400);
            echo $this->messages['notValidThreePartsUriMessage'];
        }
    }

    protected function put(): void
    {
        if (count($this->uriParts) == 3) {
            $_PUT = $this->parsePutParameters();

            if (isset($_PUT["email"]) && isset($_PUT["name"]) && isset($_PUT["gender"]) && isset($_PUT["status"])) {
                $oldEmail = $this->uriParts[self::CERTAIN_EMAIL_PARAM];
                $email = $_PUT["email"];
                $name = $_PUT["name"];
                $gender = Gender::from($_PUT["gender"]);
                $status = Status::from($_PUT["status"]);

                if (User::update($oldEmail, new User($name, $email, $gender, $status))) {
                    http_response_code(200);
                    echo $this->messages['userUpdateMessage'];
                } else {
                    http_response_code(404);
                    echo $this->messages['userDoesntExistMessage'];
                }
            } else {
                http_response_code(422);
                echo $this->messages['paramsNotSetMessage'];
            }
        } else {
            http_response_code(400);
            echo $this->messages['notValidThreePartsUriMessage'];
        }
    }

    private function parsePutParameters(): array
    {
        $s = file_get_contents("php://input");

        $arr = explode("\n", $s);

        unset($arr[count($arr) - 1]);

        foreach ($arr as $key => $value) {
            if ($key % 2 == 0) {
                unset($arr[$key]);
            }
        }

        $orderedArr = array_values($arr);

        foreach ($orderedArr as $key => $value) {
            if ($key % 2 == 0) {
                $orderedArr[$key] = str_replace('"', '', explode("=", $value)[1]);
            }
        }

        $newArr = array();

        for ($i = 0; $i < count($orderedArr); $i += 2) {
            $newArr[str_replace("\r", "", $orderedArr[$i])] = str_replace("\r", "", $orderedArr[$i + 1]);
        }

        return $newArr;
    }
}