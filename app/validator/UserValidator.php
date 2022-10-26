<?php

namespace App\Validator;

class UserValidator extends BaseValidator
{
    public function __construct()
    {
        $this->rules = [
            'email' => ['isNotEmptyField' => true, 'isEmailUnique' => true, 'isValidEmail' => true],
            'name' => ['isNotEmptyField' => true],
        ];
    }
}