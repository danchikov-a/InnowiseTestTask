<?php

namespace App\Controllers;

use App\Response;
use App\Session;

class BaseController
{
    protected Response $response;
    protected Session $session;

    public function __construct()
    {
        $this->response = new Response();
        $this->session = new Session();
    }
}