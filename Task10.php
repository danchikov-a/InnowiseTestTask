<?php

namespace src;

use InvalidArgumentException;

class Task10
{
    public function main(int $input): array
    {
        if ($input > 0) {
            $result = [$input];

            while ($input != 1) {
                $input = $input % 2 == 1 ? 3 * $input + 1 : $input / 2;
                $result[] = $input;
            }

            return $result;
        } else {
            throw new InvalidArgumentException();
        }
    }
}
