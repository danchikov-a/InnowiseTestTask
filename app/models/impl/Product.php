<?php

namespace App\Models\Impl;

use App\Models\BaseModel;
use DateTime;
use http\Exception\InvalidArgumentException;

class Product extends BaseModel
{
    protected int $id;
    protected string $name;
    protected string $manufacture;
    protected string $releaseDate;
    protected int $cost;

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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        if (!empty($name)) {
            $this->name = $name;
        } else {
            throw new InvalidArgumentException();
        }
    }

    /**
     * @return string
     */
    public function getManufacture(): string
    {
        return $this->manufacture;
    }

    /**
     * @param string $manufacture
     */
    public function setManufacture(string $manufacture): void
    {
        if (!empty($manufacture)) {
            $this->$manufacture = $manufacture;
        } else {
            throw new InvalidArgumentException();
        }
    }

    /**
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    /**
     * @param string $releaseDate
     */
    public function setReleaseDate(string $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
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
        return "Product";
    }
}