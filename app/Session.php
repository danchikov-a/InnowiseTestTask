<?php

namespace App;

class Session
{
    private bool $isSessionStarted = false;

    public function setValue(string $name, mixed $value): void
    {
        if (!$this->isSessionStarted) {
            self::start();
        }

        $_SESSION[$name] = $value;
    }

    public function unsetError(string $errorName): void
    {
        unset($_SESSION[$errorName]);
        session_destroy();
    }

    public function unsetValue(string $name): void
    {
        unset($_SESSION[$name]);
    }

    public function getValue(string $value): mixed
    {
        return $_SESSION[$value] ?? false;
    }

    public static function start(): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
}