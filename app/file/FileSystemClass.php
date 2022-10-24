<?php

namespace App\File;

use App\Models\Impl\File;
use App\Models\Impl\UploadFilesLogger;
use App\Session;
use App\Validator\FileValidator;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class FileSystemClass
{
    private FileValidator $fileValidator;
    private string $uploadPath;

    public function __construct(FileValidator $fileValidator)
    {
        $this->fileValidator = $fileValidator;
        $this->uploadPath = dirname(__DIR__, 2) . $_ENV['FILE_UPLOAD_DIRECTORY'];
    }

    public function getAllFiles(array $filesInfoFromDb): array
    {
        $path = realpath($this->uploadPath);
        $files = [];

        foreach ($filesInfoFromDb as $item) {
            $fullPath = $path . "/" . $item->getFilePath();
            $file = new File();
            $file->setFileName(basename($fullPath));
            $file->setFileSize(filesize($fullPath));
            $files[] = $file;
        }

        return $files;
    }

    public function uploadFile(array $uploadingFile): bool
    {
        @mkdir($this->uploadPath, 777);
        $file = $this->uploadPath . basename($uploadingFile["name"]);

        if ($this->fileValidator->isValidFile(["path" => $this->uploadPath, "uploadingFile" => $uploadingFile])) {
            move_uploaded_file($uploadingFile["tmp_name"], $file);
            return true;
        } else {
            return false;
        }

        /* if ($currentDirectorySize + $uploadingFile["size"] < self::STORAGE_CAPACITY_BYTES) {
             move_uploaded_file($uploadingFile["tmp_name"], $file);
             unset($_SESSION['file_error']);
             $loggerMessage = "SUCCESS: file was uploaded.";
         } else {
             $_SESSION['file_error'] = true;
             $loggerMessage = "ERROR: not enough space.";
         }

         $formattedString = sprintf("%s %s %s %s",
             $loggerMessage, $uploadingFile["name"], $uploadingFile["size"], date('d-m-y h:i:s'));
         UploadFilesLogger::writeLog($formattedString);*/
        //header("Location: /file");
    }


}