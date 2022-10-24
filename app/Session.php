<?php

namespace App;

class Session
{
    private bool $isSessionStarted = false;

    public function setValidationError(string $errorName, string $error): void
    {
        if (!$this->isSessionStarted) {
            self::start();
        }

        $_SESSION[$errorName] = $error;
    }

    public function unsetValidationError(string $errorName): void
    {
        unset($_SESSION["$errorName"]);
        session_destroy();
    }

    public static function start(): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
}