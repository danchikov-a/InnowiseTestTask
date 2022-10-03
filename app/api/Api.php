<?php

namespace App\Api;

abstract class Api
{
    protected const CERTAIN_EMAIL_PARAM = 2;
    protected array $uriParts;

    public function response(): void
    {
        $this->uriParts = explode('/', trim($_SERVER['REQUEST_URI'],'/'));

        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'GET':
                $this->methodGet();
                break;
            case 'POST':
                $this->methodPost();
                break;
            case 'DELETE':
                $this->methodDelete();
                break;
            case 'PUT':
                $this->methodPut();
                break;
        }
    }

    abstract protected function methodGet();
    abstract protected function methodPost();
    abstract protected function methodDelete();
    abstract protected function methodPut();
}