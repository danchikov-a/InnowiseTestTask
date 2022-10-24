<?php

namespace App\Validator;

use App\Models\Impl\User;

class UserValidator extends BaseValidator
{
    private function isEmailUnique(string $value): bool
    {
        if (User::checkEmailExistence($value)) {
            $this->errors["email"] = 'Such email exists';

            return false;
        }

        return true;
    }

    public function isValidUser(array $fields): bool
    {
        return $this->isNotEmptyField("name", $fields["name"]) &&
            $this->isNotEmptyField("email", $fields["email"]) &&
            $this->isValidEmail("email", $fields["email"]) &&
            $this->isEmailUnique($fields["email"]);
    }
}