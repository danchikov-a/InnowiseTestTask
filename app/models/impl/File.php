<?php

namespace App\Models\Impl;

class File
{
    private string $fileName;
    private int $fileSize;

    /**
     * @param string $fileName
     * @param int $fileSize
     */
    public function __construct(string $fileName, int $fileSize)
    {
        $this->fileName = $fileName;
        $this->fileSize = $fileSize;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @return int
     */
    public function getFileSize(): int
    {
        return $this->fileSize;
    }
}
