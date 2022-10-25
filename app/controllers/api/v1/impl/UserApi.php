<?php

namespace App\Controllers\Api\V1\Impl;

use App\Controllers\Api\V1\AbstractApi;
use App\Models\Impl\User;

class UserApi extends AbstractApi
{
    private User $user;

    public function __construct()
    {
        parent::__construct();
        $this->user = new User();
    }

    public function get(int $id): void
    {
        $user = $this->user->index($id);

        if ($user) {
            $this->response->statusCode(200);
            echo json_encode($user, JSON_PRETTY_PRINT);
        } else {
            $this->response->statusCode(404);
            echo $this->messages['userDoesntExistMessage'];
        }
    }

    public function post(): void
    {
        if (isset($_POST["email"]) && isset($_POST["name"]) && isset($_POST["gender"]) && isset($_POST["status"])) {
            $postParams = [
                'email' => $_POST["email"],
                'name' => $_POST["name"],
                'gender' => $_POST["gender"],
                'status' => $_POST["status"]
            ];

            if ($this->user->store($postParams)) {
                $this->response->statusCode(200);
                echo $this->messages['userSavedMessage'];
            } else {
                $this->response->statusCode(404);
                echo $this->messages['userExistsMessage'];
            }
        } else {
            $this->response->statusCode(422);
            echo $this->messages['paramsNotSetMessage'];
        }
    }

    public function delete(int $id): void
    {
        if ($this->user->destroy($id)) {
            $this->response->statusCode(200);
            echo $this->messages['userDeletedMessage'];
        } else {
            $this->response->statusCode(404);
            echo $this->messages['userDoesntExistMessage'];
        }
    }

    public function put(int $id): void
    {
        $_PUT = $this->parsePutParameters();

        if (isset($_PUT["email"]) && isset($_PUT["name"]) && isset($_PUT["gender"]) && isset($_PUT["status"])) {
            $putParams = [
                'email' => $_PUT["email"],
                'name' => $_PUT["name"],
                'gender' => $_PUT["gender"],
                'status' => $_PUT["status"],
                'id' => $id
            ];

            if ($this->user->update($putParams)) {
                $this->response->statusCode(200);
                echo $this->messages['userUpdateMessage'];
            } else {
                $this->response->statusCode(404);
                echo $this->messages['userDoesntExistMessage'];
            }
        } else {
            $this->response->statusCode(422);
            echo $this->messages['paramsNotSetMessage'];
        }
    }

    public function getAll(): void
    {
        $this->response->statusCode(200);
        echo json_encode($this->user->showAll(), JSON_PRETTY_PRINT);
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