<?php

namespace App\Api\Impl;

use App\Api\AbstractApi;
use App\Enums\Gender;
use App\Enums\Status;
use App\Models\Impl\User;

class UserApi extends AbstractApi
{
    private const CONFIG_PATH = '/config/config.php';

    private const API = 'api';
    private const API_USER_DOESNT_EXIST = 'userDoesntExistMessage';
    private const API_USER_SAVED = 'userSavedMessage';
    private const API_USER_EXISTS = 'userExistsMessage';
    private const API_PARAMS_NOT_SET = 'paramsNotSetMessage';
    private const API_NOT_VALID_TWO_PARTS_URI = 'notValidTwoPartsUriMessage';
    private const API_NOT_VALID_THREE_PARTS_URI = 'notValidThreePartsUriMessage';
    private const API_USER_DELETED = 'userDeletedMessage';
    private const API_USER_UPDATED = 'userUpdateMessage';

    private mixed $config;

    public function __construct()
    {
        $this->config = require dirname(__DIR__, 3) . self::CONFIG_PATH;
    }


    protected function get(): void
    {
        if (isset($this->uriParts[self::CERTAIN_EMAIL_PARAM])) {
            $user = User::getUser($this->uriParts[self::CERTAIN_EMAIL_PARAM]);

            if (!$user) {
                http_response_code(404);
                echo $this->config[self::API][self::API_USER_DOESNT_EXIST];
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
                    echo $this->config[self::API][self::API_USER_SAVED];
                } else {
                    http_response_code(404);
                    echo $this->config[self::API][self::API_USER_EXISTS];
                }
            } else {
                http_response_code(422);
                echo $this->config[self::API][self::API_PARAMS_NOT_SET];
            }
        } else {
            http_response_code(400);
            echo $this->config[self::API][self::API_NOT_VALID_TWO_PARTS_URI];
        }
    }

    protected function delete(): void
    {
        if (count($this->uriParts) == 3) {
            $email = $this->uriParts[self::CERTAIN_EMAIL_PARAM];

            if (User::delete($email)) {
                http_response_code(200);
                echo $this->config[self::API][self::API_USER_DELETED];
            } else {
                http_response_code(404);
                echo $this->config[self::API][self::API_USER_DOESNT_EXIST];
            }
        } else {
            http_response_code(400);
            echo $this->config[self::API][self::API_NOT_VALID_THREE_PARTS_URI];
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
                    echo $this->config[self::API][self::API_USER_UPDATED];
                } else {
                    http_response_code(404);
                    echo $this->config[self::API][self::API_USER_DOESNT_EXIST];
                }
            } else {
                http_response_code(422);
                echo $this->config[self::API][self::API_PARAMS_NOT_SET];
            }
        } else {
            http_response_code(400);
            echo $this->config[self::API][self::API_NOT_VALID_THREE_PARTS_URI];
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