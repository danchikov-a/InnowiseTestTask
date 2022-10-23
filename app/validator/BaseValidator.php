<?php

namespace App\Validator;

use App\Models\Impl\User;

class BaseValidator
{
    protected array $errors = [];

    protected function isNotEmptyField(string $field, string $value): bool
    {
        if (empty($value)) {
            $this->errors[$field] = 'Have to be not empty';

            return false;
        }

        return true;
    }

    protected function isValidEmail(string $field, string $value): bool
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = 'Not valid mail';

            return false;
        }

        return true;
    }

    protected function isEmailUnique(string $field, string $value): bool
    {
        if (User::checkEmailExistence($value)) {
            $this->errors[$field] = 'Such email exists';

            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}