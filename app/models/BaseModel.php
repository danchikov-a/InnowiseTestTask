<?php

namespace App\Models;

use PDO;
use PDOException;

abstract class BaseModel implements IModel
{
    protected PDO $conn;
    protected array $fields;
    protected string $table;
    protected string $className;

    public function __construct()
    {
        $this->conn = DB::getDB();
    }

    public function store(): bool
    {
        $tableColumns = [];
        $dataToSave = [];

        foreach ($this->fields as $name => $value) {
            $tableColumns[] = $name;
            $dataToSave[':' . lcfirst($name)] = $value;
        }

        $sql = sprintf("INSERT INTO %s (%s) VALUES (%s);",
            $this->table, implode(',', $tableColumns), implode(',', array_keys($dataToSave)));

        $insertStatement = $this->conn->prepare($sql);

        try {
            $insertStatement->execute($dataToSave);

            return true;
        } catch (PDOException) {
            return false;
        }
    }

    public function destroy(int $id): bool
    {
        $sql = sprintf("DELETE FROM %s WHERE :id=id", $this->table);

        $deleteStatement = $this->conn->prepare($sql);
        $deleteStatement->execute([':id' => $id]);

        return $deleteStatement->rowCount() > 0;
    }

    public function update(int $id): bool
    {
        $dataToUpdate = [];
        $params = [];

        foreach ($this->fields as $name => $value) {
            $param = lcfirst($name);
            $dataToUpdate[] = "$name = :$param";
            $params[':' . lcfirst($name)] = $value;
        }

        $params[':id'] = $id;
        $sql = sprintf("UPDATE %s SET %s WHERE Id=:id", $this->table, implode(',', $dataToUpdate));

        $insertStatement = $this->conn->prepare($sql);

        try {
            $insertStatement->execute($params);

            return true;
        } catch (PDOException) {
            return false;
        }
    }

    public function show(): array
    {
        $users = $this->conn->query("SELECT * from $this->table");

        return $users->fetchAll();
    }

    public function index(int $id): object|bool
    {
        $selectStatement = $this->conn->prepare("SELECT * FROM Users WHERE Id = :id");

        $selectStatement->execute(['id' => $id]);

        $obj = $selectStatement->fetchObject();

        if ($obj) {
            return $obj;
        } else {
            return false;
        }
    }
}