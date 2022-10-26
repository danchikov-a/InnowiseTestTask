<?php

namespace App\Services;

use App\Models\Impl\BlockingInformationLogger;
use App\Models\Impl\UserSessionInformation;

class UserSessionInformationService
{
    private const LOGIN_ATTEMPTS = 3;
    private const BLOCK_DURATION = 10;

    public function findBlockTimeAndAttempts(UserSessionInformation $userSessionInformation): array
    {
        $attempts = $userSessionInformation->getAttempts();

        if ($attempts == self::LOGIN_ATTEMPTS - 1) {
            $blockTime = time();

            $userSessionInformation->setBlockTime($blockTime);

            $logMessage = sprintf("%s %s %s", $userSessionInformation->getId(), date('m/d/Y H:i:s', $blockTime),
                date('m/d/Y H:i:s', self::BLOCK_DURATION + $blockTime));

            BlockingInformationLogger::writeLog($logMessage);
        } else {
            $attempts++;
            $blockTime = 0;
        }

        return ['blockTime' => $blockTime, 'attempts' => $attempts];
    }
}