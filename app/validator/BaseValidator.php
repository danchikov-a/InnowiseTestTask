<?php

namespace App\Validator;

use App\Models\Impl\User;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class BaseValidator
{
    protected array $errors = [];
    protected array $rules = [];

    private function isNotEmptyField(string $field, mixed $value, bool $rule): bool
    {
        if (empty($value) && $rule) {
            $this->errors[$field] = 'Have to be not empty';

            return false;
        }

        return true;
    }

    private function isEnoughSpace(string $field, array $fileInfo, int $rule): bool
    {
        $totalBytes = 0;
        $path = realpath($fileInfo["path"]);

        if ($path !== false && $path != '' && file_exists($path)) {
            foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object) {
                $totalBytes += $object->getSize();
            }
        }

        if ($totalBytes + $fileInfo["uploadingFile"]["size"] > $rule) {
            $this->errors[$field] = 'Not enough space';

            return false;
        }

        return true;
    }

    private function isEmailUnique(string $field, string $value, bool $rule): bool
    {
        if (User::checkEmailExistence($value) && $rule) {
            $this->errors[$field] = 'Such email exists';

            return true;
        }

        return false;
    }

    private function isValidEmail(string $field, string $value, bool $rule): bool
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL) && $rule) {
            $this->errors[$field] = 'Not valid mail';

            return false;
        }

        return true;
    }

    private function max(string $field, string $value, int $rule = 255): bool
    {
        if (strlen($value) > $rule) {
            $this->errors[$field] = "Field have to be less than $rule";

            return true;
        }

        return false;
    }

    private function min(string $field, string $value, int $rule = 1): bool
    {
        if (strlen($value) < $rule) {
            $this->errors[$field] = "Field have to be greater than $rule";

            return true;
        }

        return false;
    }


    public function validate(array $input): bool
    {
        $this->errors = [];

        foreach ($input as $field => $value) {
            if (array_key_exists($field, $this->rules)) {
                foreach ($this->rules[$field] as $constraint => $rule) {
                    if ($this->$constraint($field, $value, $rule)) {
                        break;
                    }
                }
            }
        }

        return empty($this->errors);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}