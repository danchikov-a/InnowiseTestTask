<?php

namespace App;

class Response
{
    public function statusCode(int $code): void
    {
        http_response_code($code);
    }

    public function redirect(string $url): void
    {
        header("Location: $url");
    }

    public function sendResponse(string $statusCode, string $redirectUri): void
    {
        header('Content-Type: application/json; charset=utf-8');

        json_encode(['statusCode' => $statusCode, 'redirectUri' => $redirectUri]);
    }
}