<?php

namespace src;

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
        $this->result = $this->result / $divider;
        return $this;
    }

    public function __toString(): string
    {
        return $this->result;
    }
}
