<?php

namespace App\Services;

use App\Models\Impl\Product;
use App\Session;

class ProductService
{
    private Product $product;
    private Session $session;

    public function __construct()
    {
        $this->product = new Product();
        $this->session = new Session();
    }

    public function getTotalCost(int $id, array $services): int
    {
        $totalCost = $this->product->index($id)->getCost();

        foreach ($services as $service) {
            if ($this->session->getValue($service->getName())) {
                $totalCost += $service->getCost();
            }
        }

        return $totalCost;
    }
}