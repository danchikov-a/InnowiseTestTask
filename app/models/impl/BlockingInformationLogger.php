<?php

namespace App\Models\Impl;

class BlockingInformationLogger
{
    public static function writeLog($message): void
    {
        Logger::writeLog($message, "blockingAddresses.log");
    }
}