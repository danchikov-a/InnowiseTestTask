<?php

namespace App\Controllers;

use App\Models\Impl\Product;
use App\Models\Impl\Service;
use App\Services\CartService;
use App\Services\ProductService;
use App\View;

class ProductController extends BaseController
{
    private Product $product;
    private Service $service;
    private ProductService $productService;

    public function __construct()
    {
        parent::__construct();
        $this->product = new Product();
        $this->service = new Service();
        $this->productService = new ProductService();
    }

    public function showAll(): void
    {
        $products = $this->product->showAll();

        View::render("/app/views/products.php", ['products' => $products]);
    }

    public function show(int $id): void
    {
        $product = $this->product->index($id);
        $services = $this->service->showAll();

        if ($product) {
            $this->response->statusCode(200);
        } else {
            $this->response->statusCode(404);
        }

        View::render("/app/views/product.php", ['product' => $product, 'services' => $services,
            'totalCost' => $this->productService->getTotalCost($id, $services)]);
    }
}