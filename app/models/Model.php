<?php

namespace App\Models;

use PDO;

class Model
{
    private const DB_HOST = 'host';
    private const DB_USER = 'user';
    private const DB_PASS = 'password';
    private const DB_CONFIG = 'db';
    private const CONFIG_PATH = '/config/config.php';

    /**
     * @return PDO
     */
    protected static function getDB(): PDO
    {
        $config = require dirname(__DIR__, 2) . self::CONFIG_PATH;
        static $db = null;

        if ($db === null) {
            $db = new PDO($config[self::DB_CONFIG][self::DB_HOST],
                $config[self::DB_CONFIG][self::DB_USER],
                $config[self::DB_CONFIG][self::DB_PASS]
            );
        }

        return $db;
    }
}