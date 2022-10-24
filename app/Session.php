<?php

namespace App;

class Session
{
    public function setValidationError(string $errorName, string $error): void
    {
        $_SESSION[$errorName] = $error;
    }

    public function unsetValidationError(string $errorName): void
    {
        unset($_SESSION["$errorName"]);
    }

    public static function start(): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
}