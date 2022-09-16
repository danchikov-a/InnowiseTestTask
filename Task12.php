<?php

namespace src;

use InvalidArgumentException;

class Task12
{
    private $number1;
    private $number2;
    private $result;

    public function __construct(int $number1, int $number2)
    {
        $this->number1 = $number1;
        $this->number2 = $number2;
    }

    public function add(): Task12
    {
        $this->result = $this->number1 + $this->number2;

        return $this;
    }

    public function subtract(): Task12
    {
        $this->result = $this->number1 - $this->number2;

        return $this;
    }

    public function multiply(): Task12
    {
        $this->result = $this->number1 * $this->number2;

        return $this;
    }

    public function divideBy($divider): Task12
    {
        if ($divider != 0) {
            $this->result = $this->result / $divider;

            return $this;
        } else {
            throw new InvalidArgumentException();
        }
    }

    public function divide(): Task12
    {
        if ($this->number2 != 0) {
            $this->result = $this->number1 / $this->number2;

            return $this;
        } else {
            throw new InvalidArgumentException();
        }
    }

    public function multiplyBy(int $multiplier): Task12
    {
        $this->result = $this->result * $multiplier;

        return $this;
    }

    public function __toString(): string
    {
        return $this->result;
    }
}
