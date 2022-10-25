<?php

namespace App\Models;

class BaseLogger implements ILogger
{
    private const LOGS_PATH = "/logs";

    public static function writeLog($message, $fileName): void
    {
        $loggerFolder = $_SERVER['DOCUMENT_ROOT'] . self::LOGS_PATH;
        @mkdir($loggerFolder, 777, true);

        $loggerFileData = $loggerFolder . "/" . $fileName;
        $fp = fopen($loggerFileData, "a+");
        fwrite($fp, $message . "\n");
        fclose($fp);
    }
}