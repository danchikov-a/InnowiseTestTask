<?php

namespace App\Models\Impl;

class UploadFilesLogger
{
    public static function writeLog($message): void
    {
        Logger::writeLog($message, '/upload_' . date('d-m-y') . '.log');
    }
}