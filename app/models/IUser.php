<?php

namespace src;

interface IUser
{
    public function addUser(User $user);
    public function deleteUser(string $email);
    public function editUser(string $email);
    public function getUsers();
}