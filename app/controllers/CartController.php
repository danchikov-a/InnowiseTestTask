<?php

namespace App\Controllers;

use App\Models\Impl\Product;
use App\Services\CartService;
use App\View;

class CartController extends BaseController
{
    private CartService $cartService;
    private Product $product;

    public function __construct()
    {
        parent::__construct();
        $this->cartService = new CartService();
        $this->product = new Product();
    }

    public function addToCart(int $id)
    {
        $product = $this->product->index($id);

        $this->cartService->addProduct($product);

        $this->response->sendResponse(200, "/cart");
        $this->response->redirect("/cart");
    }

    public function deleteFromCart(int $id)
    {
        unset($this->session->getValue("cart")[$id]);

        $this->response->sendResponse(200, "/cart");
        $this->response->redirect("/cart");
    }

    public function showAll()
    {
        $cart = $this->session->getValue("cart");
        $products = [];

        if ($cart) {
            foreach ($cart as $id => $item) {
                $products[] = $this->product->index($id);
            }
        }

        View::render("/app/views/cart.php", ['products' => $products, 'totalCost' => $this->cartService->total()]);
    }
}