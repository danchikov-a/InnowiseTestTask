<?php

namespace App\Models\Impl;

use App\Models\BaseModel;

class File extends BaseModel
{
    private int $id;
    private string $filePath;
    private string $fileName;
    private int $fileSize;

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * @param string $filePath
     */
    public function setFilePath(string $filePath): void
    {
        $this->filePath = $filePath;
    }

    protected static function getTableName(): string
    {
        return "Files";
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $fileName
     */
    public function setFileName(string $fileName): void
    {
        $this->fileName = $fileName;
    }

    /**
     * @param int $fileSize
     */
    public function setFileSize(int $fileSize): void
    {
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
