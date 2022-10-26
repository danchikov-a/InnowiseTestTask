<?php

namespace App\Services;

use App\Models\Impl\File;
use App\Validator\FileValidator;

class FileManager
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

        if ($this->fileValidator->validate(["path" => $this->uploadPath, "uploadingFile" => $uploadingFile])) {
            move_uploaded_file($uploadingFile["tmp_name"], $file);

            return true;
        } else {
            return false;
        }
    }
}