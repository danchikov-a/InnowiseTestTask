<?php

namespace src;

class Task12
{
    private $number1;
    private $number2;

    public function __construct(int $number1, int $number2)
    {
        $this->number1 = $number1;
        $this->number2 = $number2;
    }

    public function add(): Task12
    {
        return new Task12($this->number1 + $this->number2, null);
    }

    public function subtract(): Task12
    {
        return new Task12($this->number1 - $this->number2, null);
    }

    public function multiply(): Task12
    {
        return new Task12($this->number1 * $this->number2, null);
    }

    public function divideBy($divider): int
    {
        return $this->number1 / $divider;
    }

    public function __toString(): string
    {
        return $this->number1;
    }
}