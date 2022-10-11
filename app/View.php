<?php

namespace App;

class View
{
    public static function render(string $view): void
    {
        require_once dirname(__DIR__) . "/" . $view;
    }
}