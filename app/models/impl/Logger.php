<?php

namespace App\Models\Impl;

use App\Models\ILogger;

class Logger implements ILogger
{
    private const LOGS_PATH = "/logs";

    public static function writeLog($message, $fileName): void
    {
        $loggerFolder = dirname(__DIR__, 3) . self::LOGS_PATH;
        @mkdir($loggerFolder, 777, true);

        $loggerFileData = $loggerFolder . "/" . $fileName;
        $fp = fopen($loggerFileData, "a+");
        fwrite($fp, $message . "\n");
        fclose($fp);
    }
}