<?php

namespace App\Models;

abstract class BaseModel implements IModel
{
    protected static DB $db;

    public function __construct()
    {
        self::$db = DB::getInstance();
    }

    public function store(array $data): bool
    {
        $columns = [];
        $paramsNames = [];

        foreach ($data as $columnName => $value) {
            $columns[] = $columnName;
            $paramsNames[':' . $columnName] = "'$value'";
        }

        $sql = sprintf("INSERT INTO %s (%s) VALUES (%s);",
            static::getTableName(), implode(',', $columns), implode(',', array_keys($paramsNames)));

        return self::$db->changeRecord($sql, $data);
    }

    public function destroy(int $id): bool
    {
        return self::$db->changeRecord(
            sprintf("DELETE FROM %s WHERE id = :id", static::getTableName()),
            [':id' => $id]
        );
    }

    public static function checkEmailExistence(string $email): array|false
    {
        return self::$db->getRecord(
            sprintf("SELECT * FROM %s WHERE `email` = :email", static::getTableName()),
            ['email' => $email]
        );
    }

    public function update(array $data): bool
    {
        $columnParams = [];
        $paramsValues = [];

        foreach ($data as $columnName => $value) {
            $columnParams[] = "$columnName = '$value'";
        }

        $sql = sprintf("UPDATE %s SET %s WHERE id = %s",
            static::getTableName(), implode(', ', $columnParams), $data['id']);

        return self::$db->changeRecord($sql, $paramsValues);
    }

    public function showAll(): array
    {
        return self::$db->query(sprintf("SELECT * FROM %s;",
            static::getTableName()), [], static::class);
    }

    public function index(int $id): self|null
    {
        $entities = self::$db->query(
            sprintf("SELECT * FROM %s WHERE id=:id;", static::getTableName()),
            [':id' => $id],
            static::class
        );

        return $entities ? $entities[0] : null;
    }

    abstract protected static function getTableName(): string;
}