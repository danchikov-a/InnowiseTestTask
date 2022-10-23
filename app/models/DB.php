<?php

namespace App\Models;

use PDO;

class DB
{
    private static ?self $instance = null;

    private object $pdo;

    private function __construct()
    {
        $dsn = sprintf("mysql:host=%s;port=%s;dbname=%s",
            $_ENV['DATABASE_HOST'], $_ENV['DATABASE_PORT'], $_ENV['DATABASE_DB_NAME']);

        $this->pdo = new PDO($dsn, $_ENV['DATABASE_USER'], $_ENV['DATABASE_PASSWORD']);
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function query(string $sql, array $params = [], string $className = 'stdClass'): array|null
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if (false === $result) {
            return null;
        }

        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $className);
    }

    public function changeRecord(string $sql, array $values): bool
    {
        return $this->pdo->prepare($sql)->execute($values);
    }

    public function getRecord(string $sql, array $values): array|false
    {
        $sth = $this->pdo->prepare($sql);
        $sth->execute($values);

        return $sth->fetch(PDO::FETCH_ASSOC);
    }
}