<?php

namespace App\Validator;

class CheckoutValidator extends BaseValidator
{
    public function __construct()
    {
        $this->rules = [
            'phone' => ['isNotEmptyField' => true],
            'address' => ['isNotEmptyField' => true],
            'name' => ['isNotEmptyField' => true]
        ];
    }
}