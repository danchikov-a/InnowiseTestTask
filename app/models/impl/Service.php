<?php

namespace App\Models\Impl;

use App\Models\BaseModel;
use DateTime;
use http\Exception\InvalidArgumentException;

class Service extends BaseModel
{
    private int $id;
    private string $name;
    private int $deadLine;
    private int $cost;

    public function getServiceByName(string $name): bool|array
    {
        return self::$db->getRecord(
            sprintf("SELECT * FROM %s WHERE `name` = :name",
                static::getTableName()), ['name' => $name]
        );
    }
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getDeadLine(): int
    {
        return $this->deadLine;
    }

    /**
     * @param int $deadLine
     */
    public function setDeadLine(int $deadLine): void
    {
        $this->deadLine = $deadLine;
    }


    /**
     * @return int
     */
    public function getCost(): int
    {
        return $this->cost;
    }

    /**
     * @param int $cost
     */
    public function setCost(int $cost): void
    {
        if ($cost > 0) {
            $this->cost = $cost;
        } else {
            throw new InvalidArgumentException();
        }
    }

    protected static function getTableName(): string
    {
        return "Service";
    }
}