<?php

namespace src;

use InvalidArgumentException;

class Task2
{
    public const SEPARATOR = ".";
    public const SECONDS_IN_DAY = 86400;
    public const AMOUNT_OF_DATE_COMPONENTS = 3;

    public function main(string $date): int
    {
        $dateComponents = explode(self::SEPARATOR, $date);

        if (count($dateComponents) == self::AMOUNT_OF_DATE_COMPONENTS) {
            $days = $dateComponents[0];
            $months = $dateComponents[1];
            $years = $dateComponents[2];

            if (checkdate($months, $days, $years)) {
                return (int)((time() - strtotime($date)) / self::SECONDS_IN_DAY);
            } else {
                throw new InvalidArgumentException();
            }
        } else {
            throw new InvalidArgumentException();
        }
    }
}
