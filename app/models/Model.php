<?php

namespace src;

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
        $config = require $_SERVER['DOCUMENT_ROOT'] . self::CONFIG_PATH;
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