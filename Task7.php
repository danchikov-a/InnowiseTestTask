<?php

namespace src;

use InvalidArgumentException;

class Task7
{
    public function main(array $arr, int $position): array
    {
        if ($position >= 0) {
            unset($arr[$position]);
            $newArray = [];

            foreach ($arr as $value) {
                $newArray[] = $value;
            }

            return $newArray;
        } else {
            throw new InvalidArgumentException();
        }
    }
}
