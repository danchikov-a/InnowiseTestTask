<?php

namespace App\Api;

abstract class AbstractApi
{
    protected const CERTAIN_EMAIL_PARAM = 2;

    protected array $uriParts;

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