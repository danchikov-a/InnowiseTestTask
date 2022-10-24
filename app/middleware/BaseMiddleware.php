<?php

namespace App\Middleware;

use App\Response;

class BaseMiddleware
{
    protected Response $response;

    public function __construct()
    {
        $this->response = new Response();
    }
}