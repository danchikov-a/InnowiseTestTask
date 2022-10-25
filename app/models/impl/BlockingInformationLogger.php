<?php

namespace App\Models\Impl;

use App\Models\BaseLogger;

class BlockingInformationLogger
{
    public static function writeLog($message): void
    {
        BaseLogger::writeLog($message, "blockingAddresses.log");
    }
}