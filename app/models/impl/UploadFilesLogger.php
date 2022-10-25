<?php

namespace App\Models\Impl;

use App\Models\BaseLogger;

class UploadFilesLogger
{
    public static function writeLog($message): void
    {
        BaseLogger::writeLog($message, 'upload_' . date('d-m-y') . '.log');
    }
}