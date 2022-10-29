<?php

namespace App\Controllers;

use App\View;

class CheckoutController extends BaseController
{
    public function showCheckout()
    {
        View::render("app/views/checkout.php");
    }
}