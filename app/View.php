<?php

namespace App;

class View
{
    public static function render(string $view, array $args = []): void
    {
        extract($args, EXTR_SKIP);
        ob_start();
        include_once dirname(__DIR__) . "/" . $view;
        $buffer = ob_get_contents();
        ob_end_clean();

        echo $buffer;
    }
}