<?php

namespace App\Validator;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class FileValidator extends BaseValidator
{
    private const STORAGE_CAPACITY_BYTES = 7168;

    public function isValidFile(array $fields): bool
    {
        return $this->isNotEmptyField("uploadingFile", $fields["uploadingFile"]["name"]) &&
            $this->isEnoughSpace(["path" => $fields["path"], "uploadingFile" => $fields["uploadingFile"]]);
    }

    public function isEnoughSpace(array $fileInfo): bool
    {
        $totalBytes = 0;
        $path = realpath($fileInfo["path"]);

        if ($path !== false && $path != '' && file_exists($path)) {
            foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object) {
                $totalBytes += $object->getSize();
            }
        }

        if ($totalBytes + $fileInfo["uploadingFile"]["size"] > self::STORAGE_CAPACITY_BYTES) {
            $this->errors["file"] = 'Not enough space';

            return false;
        }

        return true;
    }
}