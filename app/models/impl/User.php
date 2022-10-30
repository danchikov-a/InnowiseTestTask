<?php

namespace App\Models\Impl;

use App\Models\BaseModel;
use JsonSerializable;

class User extends BaseModel implements JsonSerializable
{
    private int $id;
    private string $email;
    private string $name;
    private string $gender;
    private string $status;

    protected static function getTableName(): string
    {
        return 'Users';
    }

    public function isUserEnteredRightCredentials(array $inputData): array|false
    {
        return self::$db->getRecord(
            sprintf("SELECT * FROM %s WHERE `email` = :email AND `name` = :name AND `password` = :password",
                static::getTableName()), ['email' => $inputData["email"], 'name' => $inputData["name"], 'password' => $inputData["password"]]
        );
    }

    public function getIdByEmail(string $email): int
    {
        return self::$db->getRecord(
            sprintf("SELECT id FROM %s WHERE `email` = :email",
                static::getTableName()), ['email' => $email]
        )["id"];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}