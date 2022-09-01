<?php

namespace src;

use InvalidArgumentException;

class Task6
{
    const MONTHS = 12;

    public function main(int $year, int $lastYear, int $month, int $lastMonth, string $day = 'Monday'): int
    {
        if ($year < $lastYear || ($year == $lastYear && $month < $lastMonth)) {
            $days = array(1 => "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
            $amount = 0;

            for ($currentYear = $year; $currentYear <= $lastYear; $currentYear++) {
                for ($currentMonth = $month;
                     $currentMonth <= self::MONTHS && !($currentYear == $lastYear && $currentMonth == $lastMonth);
                     $currentMonth++) {
                    $firstDayOfMonth = date("w", strtotime("01.$currentMonth.$currentYear"));

                    if ($firstDayOfMonth == array_search($day, $days)) {
                        $amount++;
                    }
                }
            }

            return $amount;
        } else {
            throw new InvalidArgumentException();
        }
    }
}