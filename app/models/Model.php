<?php

namespace src;

use PDO;

class Model
{
    private const DB_HOST = 'myapp.cfg.DB_HOST';
    private const DB_USER = 'myapp.cfg.DB_USER';
    private const DB_PASS = 'myapp.cfg.DB_PASS';
    private const CONFIG_PATH = '/app/config/php.ini';

    /**
     * @return PDO
     */
    protected static function getDB(): PDO
    {
        static $db = null;

        if ($db === null) {
            $credentials = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . self::CONFIG_PATH);
            $db = new PDO($credentials[self::DB_HOST], $credentials[self::DB_USER], $credentials[self::DB_PASS]);
        }

        return $db;
    }
}