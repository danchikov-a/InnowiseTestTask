<?php

namespace App\Models;

interface IModel
{
    public function store(array $data): bool;
    public function destroy(int $id): bool;
    public function update(array $data): bool;
    public function showAll(): array;
    public function index(int $id): object|null;
}