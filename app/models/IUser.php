<?php

namespace src;

interface IUser
{
    public static function save(User $user): bool;
    public static function delete(string $email);
    public static function update(string $oldEmail, User $user): bool;
    public static function getUsers(): array;
}