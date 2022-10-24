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

    private function isValidEmail(string $value): bool
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors["email"] = 'Not valid mail';

            return false;
        }

        return true;
    }

    public function isValidUser(array $fields): bool
    {
        return $this->isNotEmptyField("name", $fields["name"]) &&
            $this->isNotEmptyField("email", $fields["email"]) &&
            $this->isValidEmail($fields["email"]) &&
            $this->isEmailUnique($fields["email"]);
    }
}