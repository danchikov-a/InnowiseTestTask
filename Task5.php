<?php

namespace src;

use InvalidArgumentException;

class Task5
{
    public function main(int $length): string
    {
        if ($length > 0) {
            $number1 = 0;
            $number2 = 1;

            while (strlen($number2) < $length) {
                $number3 = $this->bitwiseAddition($number1, $number2);
                $number1 = $number2;
                $number2 = $number3;
            }

            return $number2;
        } else {
            throw new InvalidArgumentException();
        }
    }

    private function bitwiseAddition(string $number1, string $number2): string
    {
        $length1 = strlen($number1) - 1;
        $length2 = strlen($number2) - 1;
        $maxLength = max($length1, $length2);
        $inMemory = 0;
        $result = "";

        for ($i = 0; $i <= $maxLength; $i++) {
            $op1 = $i <= $length1 ? $number1[$length1 - $i] : 0;
            $op2 = $i <= $length2 ? $number2[$length2 - $i] : 0;
            $result = ($op1 + $op2 + $inMemory) % 10 . $result;
            $inMemory = (int)(($op1 + $op2 + $inMemory) / 10);
        }

        if ($inMemory) {
            $result = $inMemory . $result;
        }

        return $result;
    }
}