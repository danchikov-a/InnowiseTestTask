<?php

namespace App\Controllers;

use App\Cookie;
use App\Response;
use App\Session;

class BaseController
{
    protected Response $response;
    protected Session $session;
    protected Cookie $cookie;

    public function __construct()
    {
        $this->response = new Response();
        $this->session = new Session();
        $this->cookie = new Cookie();
    }
}