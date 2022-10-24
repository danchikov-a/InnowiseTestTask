<?php

namespace App\Controllers;

use App\File\FileSystemClass;
use App\Models\Impl\File;
use App\Models\Impl\UploadFilesLogger;
use App\Validator\FileValidator;
use App\View;

class FileController extends BaseController
{
    private File $file;
    private FileSystemClass $fileSystemClass;
    private FileValidator $fileValidator;
    private UploadFilesLogger $uploadFilesLogger;

    public function __construct()
    {
        parent::__construct();
        $this->file = new File();
        $this->fileValidator = new FileValidator();
        $this->fileSystemClass = new FileSystemClass($this->fileValidator);
        $this->uploadFilesLogger = new UploadFilesLogger();
    }

    public function all(): void
    {
        $files = $this->fileSystemClass->getAllFiles($this->file->showAll());

        View::render('app/views/fileUploadForm.php', ['files' => $files]);
    }

    public function add(): void
    {
        $postParams = [
            'filePath' => basename($_FILES["file"]["name"]),
        ];

        if ($this->fileSystemClass->uploadFile($_FILES["file"])) {
            $this->file->store($postParams);
            $this->session->unsetValidationError('file_error');
            $this->response->sendResponse(200, "/file");
        } else {
            $this->session->setValidationError('file_error', $this->fileValidator->getErrors()["file"]);
            $this->response->sendResponse(409, "/file");
        }

        $this->response->redirect("/file");
    }
}