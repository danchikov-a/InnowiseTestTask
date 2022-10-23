<?php

namespace App\Validator;

class UserValidator extends BaseValidator
{
    public function isValidUser(array $fields): bool
    {
        return $this->isNotEmptyField("name", $fields["name"]) &&
            $this->isNotEmptyField("email", $fields["email"]) &&
            $this->isValidEmail("email", $fields["email"]) &&
            $this->isEmailUnique("email", $fields["email"]);
    }
}