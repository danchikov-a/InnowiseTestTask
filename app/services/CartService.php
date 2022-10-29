<?php

namespace App\Services;

use App\Models\Impl\Product;
use App\Models\Impl\Service;
use App\Session;
use App\View;

class CartService
{
    private Session $session;
    private Product $product;
    private Service $service;

    public function __construct()
    {
        $this->session = new Session();
        $this->product = new Product();
        $this->service = new Service();
    }

    public function addProduct(Product $product): void
    {
        $servicesRelatedToProduct = [];

        foreach ($_SESSION as $key => $element) {
            if ($key != "cart") {
                $servicesRelatedToProduct[] = $key;
                $this->session->unsetValue($key);
            }
        }

        if ($this->session->getValue("cart")) {
            $cart = $_SESSION["cart"];
        }

        $cart[$product->getId()] = $servicesRelatedToProduct;

        $this->session->unsetValue("cart");
        $this->session->setValue("cart", $cart);
    }

    public function total(): int
    {
        $cart = $this->session->getValue("cart");
        $totalCost = 0;

        foreach ($cart as $productId => $services) {
            $totalCost += $this->product->index($productId)->getCost();

            foreach ($services as $service) {
                $totalCost += $this->service->getServiceByName($service)["cost"];
            }
        }

        return $totalCost;
    }
}