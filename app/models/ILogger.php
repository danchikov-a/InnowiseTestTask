<?php

namespace App\Models;

interface ILogger
{
    public static function writeLog($message, $fileName);
}