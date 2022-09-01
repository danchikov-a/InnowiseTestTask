<?php

namespace src;

class Task4
{
    public function main(string $inputString): string
    {
        $separators = ['-', '_', ' '];

        for ($i = 0; $i < strlen($inputString); $i++) {
            if (in_array($inputString[$i], $separators)) {
                $inputString = substr_replace($inputString, '', $i, 1);
                $inputString[$i] = strtoupper($inputString[$i]);
            }
        }

        return $inputString;
    }
}
