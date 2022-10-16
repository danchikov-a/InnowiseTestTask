<?php

namespace App\Models\Impl;

use http\Exception\InvalidArgumentException;

class UserSessionInformation
{
    private string $ip;
    private int $attempts;
    private int $blockTime;

    public const BLOCK_DURATION = 10;

    public function checkBlockTime(): bool
    {
        return time() - $this->blockTime > self::BLOCK_DURATION;
    }

    public function addAttempt(): void
    {
        $this->attempts++;
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

    /**
     * @return int
     */
    public function getIp(): int
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIp(string $ip): void
    {
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            $this->ip = $ip;
        } else {
            throw new InvalidArgumentException();
        }
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
        if ($attempts > 0) {
            $this->attempts = $attempts;
        } else {
            throw new InvalidArgumentException();
        }
    }
}