<?php

namespace App\Api;

abstract class AbstractApi
{
    protected const CERTAIN_EMAIL_PARAM = 3;
    private const CONFIG_PATH = '/config/apiMessages.php';

    protected mixed $config;
    protected array $messages;
    protected array $uriParts;

    public function __construct()
    {
        $this->config = require dirname(__DIR__, 2) . self::CONFIG_PATH;
        $this->messages = $this->config['api'];
    }

    public function response(): void
    {
        $this->uriParts = explode('/', trim($_SERVER['REQUEST_URI'],'/'));

        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'GET':
                $this->get();
                break;
            case 'POST':
                $this->post();
                break;
            case 'DELETE':
                $this->delete();
                break;
            case 'PUT':
                $this->put();
                break;
        }
    }

    abstract protected function get();
    abstract protected function post();
    abstract protected function delete();
    abstract protected function put();
}