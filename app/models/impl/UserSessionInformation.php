<?php

namespace App\Models\Impl;

use App\Models\BaseModel;

class UserSessionInformation extends BaseModel
{
    private int $id;
    private string $ip;
    private int $attempts;
    private int $blockTime;

    public function getByIp(string $ip): self|null
    {
        $entities = self::$db->query(
            sprintf("SELECT * FROM %s WHERE `ip` = :ip", static::getTableName()),
            ['ip' => $ip],
            static::class
        );

        return $entities ? $entities[0] : null;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIp(string $ip): void
    {
        $this->ip = $ip;
    }

    /**
     * @return int
     */
    public function getAttempts(): int
    {
        return $this->attempts;
    }

    /**
     * @param int $attempts
     */
    public function setAttempts(int $attempts): void
    {
        $this->attempts = $attempts;
    }

    /**
     * @return int
     */
    public function getBlockTime(): int
    {
        return $this->blockTime;
    }

    /**
     * @param int $blockTime
     */
    public function setBlockTime(int $blockTime): void
    {
        $this->blockTime = $blockTime;
    }

    protected static function getTableName(): string
    {
        return "UserSessionInformation";
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
}