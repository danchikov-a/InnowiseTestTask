<?php

namespace App\Controllers;

use App\Models\Impl\Checkout;
use App\Validator\CheckoutValidator;
use App\View;

class CheckoutController extends BaseController
{
    private Checkout $checkout;
    private CheckoutValidator $checkoutValidator;

    public function __construct()
    {
        parent::__construct();
        $this->checkout = new Checkout();
        $this->checkoutValidator = new CheckoutValidator();
    }

    public function showCheckout(): void
    {
        View::render("app/views/checkout.php");
    }

    public function checkout(): void
    {
        $postParams = ['name' => $_POST['name'], 'phone' => $_POST['phone'], 'address' => $_POST['address'],
            'userId' => $this->cookie->getCookie("userId")];

        if ($this->checkoutValidator->validate($postParams)) {
            if ($this->checkout->store($postParams)) {
                $this->response->sendResponse("200", "/products");
                $this->session->unsetValue("cart");
                $this->response->redirect("/products");
            } else {
                $this->response->sendResponse("403", "/checkout");

                $this->response->redirect("/cart/checkout");
            }
        }
    }
}