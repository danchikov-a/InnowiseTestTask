<?php

namespace src;

use InvalidArgumentException;

class Task9
{
    const AMOUNT_OF_NUMBERS = 3;
    const RETURN_FORMAT = "%s + %s + %s = %s";

    public function main(array $arr, int $number): array
    {
        if (count($arr) >= self::AMOUNT_OF_NUMBERS) {
            $result = [];
            $length = count($arr) - self::AMOUNT_OF_NUMBERS;

            for ($i = 0; $i <= $length; $i++) {
                if ($arr[$i] + $arr[$i + 1] + $arr[$i + 2] == $number) {
                    $result[] = sprintf(self::RETURN_FORMAT, $arr[$i], $arr[$i + 1], $arr[$i + 2], $number);
                }
            }

            return $result;
        } else {
            throw new InvalidArgumentException();
        }
    }
}