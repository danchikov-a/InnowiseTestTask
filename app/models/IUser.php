<?php

namespace App\Models;

use App\Models\Impl\User;

interface IUser
{
    public static function save(User $user): bool;
    public static function delete(string $email);
    public static function update(string $oldEmail, User $user): bool;
    public static function getUsers(): array;
}