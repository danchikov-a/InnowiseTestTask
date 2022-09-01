<?php

namespace src;

use InvalidArgumentException;

class Task3
{
    public function main(int $number): int
    {
        if ($number > 0) {
            do {
                $sum = 0;

                do {
                    $sum += (int)$number % 10;
                    $number = (int)$number / 10;
                } while ($number);

                $number  = $sum;
            } while ($number > 9);

            return $sum;
        } else {
            throw new InvalidArgumentException();
        }
    }
}
