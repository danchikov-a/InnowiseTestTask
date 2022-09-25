<?php

namespace src;

interface IUser
{
    public static function save(User $user);
    public static function delete(string $email);
    public static function edit(string $oldEmail, User $user);
    public static function getUsers();
}