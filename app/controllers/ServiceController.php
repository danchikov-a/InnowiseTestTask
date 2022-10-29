<?php

namespace App\Controllers;

use App\Models\Impl\Service;
use App\View;

class ServiceController extends BaseController
{
    private Service $service;

    public function __construct()
    {
        parent::__construct();
        $this->service = new Service();
    }

    public function add(int $productId, int $serviceId)
    {
        $service = $this->service->index($serviceId);

        $this->session->setValue($service->getName(), true);

        $this->response->sendResponse(200, "/products/$productId");
        $this->response->redirect("/products/$productId");
    }

    public function delete(int $productId, int $serviceId)
    {
        $service = $this->service->index($serviceId);
        $this->session->unsetValue($service->getName());

        $this->response->sendResponse(200, "/products/$productId");
        $this->response->redirect("/products/$productId");
    }

    public function showAll()
    {
        View::render("/app/views/services");
    }

    public function show(int $id)
    {
        View::render("/app/views/services/$id");
    }
}