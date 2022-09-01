<?php

namespace src;

class Task1
{
    public const MORE_THAN_30_TEXT = "More than 30";
    public const MORE_THAN_20_TEXT = "More than 20";
    public const MORE_THAN_10_TEXT = "More than 10";
    public const EQUAL_OR_LESS_THAT_10_TEXT = "Equal or less than 10";

    public function main(int $number): string
    {
        $result = $number > 30
            ? self::MORE_THAN_30_TEXT
            : ($number > 20
                ? self::MORE_THAN_20_TEXT
                : ($number > 10
                    ? self::MORE_THAN_10_TEXT
                    : self::EQUAL_OR_LESS_THAT_10_TEXT));

        return $result . "\n";
    }
}
