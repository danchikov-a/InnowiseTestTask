<?php

namespace App\Models;

interface IModel
{
    public function store(): bool;
    public function destroy(int $id): bool;
    public function update(int $id): bool;
    public function show(): array;
    public function index(int $id): object|bool;
}