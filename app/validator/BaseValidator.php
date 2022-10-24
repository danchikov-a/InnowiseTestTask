<?php

namespace App\Validator;

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

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}