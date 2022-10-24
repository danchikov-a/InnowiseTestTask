<?php

namespace App;

class Cookie
{
    private const COOKIE_LIFETIME = 3600;

    public function setCookie(string $cookieName, string $value): void
    {
        setcookie($cookieName, $value, time() + self::COOKIE_LIFETIME);
    }

    public function unsetCookie(string $cookieName): void
    {
        setcookie($cookieName, "", time() - self::COOKIE_LIFETIME);
    }
}