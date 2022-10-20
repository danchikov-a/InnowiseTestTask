<?php

namespace App\Models;

use PDO;

class DB
{
    public static function getDB(): PDO
    {
        $dsn = sprintf("mysql:host=%s;port=%s;dbname=%s",
            $_ENV['DATABASE_HOST'], $_ENV['DATABASE_PORT'], $_ENV['DATABASE_DB_NAME']);

        return new PDO($dsn, $_ENV['DATABASE_USER'], $_ENV['DATABASE_PASSWORD']);
    }
}