<?php

namespace App\Controllers;

use App\Models\Impl\File;
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
        //use at sign because all error messages are ignored so if such dir exists we won't see message on our page
        @mkdir(dirname(__DIR__, 2) . self::UPLOAD_DIRECTORY, 777);
        $directory = dirname(__DIR__, 2) . self::UPLOAD_DIRECTORY;
        $file = $directory . basename($_FILES["file"]["name"]);

        $currentDirectorySize = $this->getDirectorySize($directory);

        if ($currentDirectorySize + $_FILES["file"]["size"] < self::STORAGE_CAPACITY_BYTES) {
            move_uploaded_file($_FILES["file"]["tmp_name"], $file);

            unset($_SESSION['file_error']);
        } else {
            $_SESSION['file_error'] = true;
        }

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