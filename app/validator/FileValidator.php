<?php

namespace App\Validator;

class FileValidator extends BaseValidator
{
    public function __construct()
    {
        $this->rules = [
            'uploadingFile' => ['isNotEmptyField' => true],
            'path' => ['isNotEmptyField' => true, 'isEnoughSpace' => 7168],
        ];
    }
}