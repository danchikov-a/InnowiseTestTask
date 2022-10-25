<?php

namespace App\Controllers\Api\V1;

use App\Response;

abstract class AbstractApi
{
    private const CONFIG_MESSAGE_PATH = '/config/apiMessages.php';

    protected array $messages;
    protected Response $response;

    public function __construct()
    {
        $this->messages = require $_SERVER['DOCUMENT_ROOT'] . self::CONFIG_MESSAGE_PATH;
        $this->response = new Response();
    }

    abstract public function get(int $id): void;

    abstract public function post(): void;

    abstract public function delete(int $id): void;

    abstract public function put(int $id): void;

    abstract public function getAll(): void;
}