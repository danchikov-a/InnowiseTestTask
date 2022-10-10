<?php

namespace App\Controllers;

use App\Models\Impl\File;
use App\Models\Impl\Logger;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class FileController
{
    private const UPLOAD_DIRECTORY = "/uploads/";
    private const STORAGE_CAPACITY_BYTES = 7168;

    public function all(): void
    {
        $path = realpath(dirname(__DIR__, 2) . self::UPLOAD_DIRECTORY);

        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object) {
            $fileSize = filesize($object);
            $fileName = basename($object);

            $_GET["files"][] = new File($fileName, $fileSize);
        }
    }

    public function create(): void
    {
        $uploadingFile = $_FILES["file"];
        //use at sign because all error messages are ignored so if such dir exists we won't see message on our page
        @mkdir(dirname(__DIR__, 2) . self::UPLOAD_DIRECTORY, 777);
        $directory = dirname(__DIR__, 2) . self::UPLOAD_DIRECTORY;
        $file = $directory . basename($uploadingFile["name"]);

        $currentDirectorySize = $this->getDirectorySize($directory);

        if ($currentDirectorySize + $uploadingFile["size"] < self::STORAGE_CAPACITY_BYTES) {
            move_uploaded_file($uploadingFile["tmp_name"], $file);
            unset($_SESSION['file_error']);
            $loggerMessage = "SUCCESS: file was uploaded.";
        } else {
            $_SESSION['file_error'] = true;
            $loggerMessage = "ERROR: not enough space.";
        }

        $formattedString = sprintf("%s %s %s %s",
            $loggerMessage, $uploadingFile["name"], $uploadingFile["size"], date('d-m-y h:i:s'));
        Logger::writeLog($formattedString);

        header("Location: /file");
    }

    private function getDirectorySize(string $path): int
    {
        $totalBytes = 0;
        $path = realpath($path);

        if ($path !== false && $path != '' && file_exists($path)) {
            foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object) {
                $totalBytes += $object->getSize();
            }
        }

        return $totalBytes;
    }
}