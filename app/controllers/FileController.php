<?php

namespace App\Controllers;

use App\Models\Impl\File;
use App\Models\Impl\UploadFilesLogger;
use App\Services\FileManager;
use App\Validator\FileValidator;
use App\View;

class FileController extends BaseController
{
    private File $file;
    private FileManager $fileManager;
    private FileValidator $fileValidator;

    public function __construct()
    {
        parent::__construct();
        $this->file = new File();
        $this->fileValidator = new FileValidator();
        $this->fileManager = new FileManager($this->fileValidator);
    }

    public function all(): void
    {
        $files = $this->fileManager->getAllFiles($this->file->showAll());

        View::render('app/views/fileUploadForm.php', ['files' => $files]);
    }

    public function add(): void
    {
        $postParams = [
            'filePath' => basename($_FILES["file"]["name"]),
        ];

        if ($this->fileManager->uploadFile($_FILES["file"])) {
            $this->file->store($postParams);
            $this->session->unsetValidationError('file_error');
            $this->response->sendResponse(200, "/file");

            UploadFilesLogger::writeLog(sprintf("%s %s %s %s",
                "SUCCESS: file was uploaded.",
                $_FILES["file"]["name"],
                $_FILES["file"]["size"],
                date('d-m-y h:i:s')
            ));
        } else {
            $this->session->setValidationError('file_error', $this->fileValidator->getErrors()["file"]);
            $this->response->sendResponse(409, "/file");

            UploadFilesLogger::writeLog(sprintf("%s %s %s %s",
                "ERROR: not enough space.",
                $_FILES["file"]["name"],
                $_FILES["file"]["size"],
                date('d-m-y h:i:s')
            ));
        }

        $this->response->redirect("/file");
    }
}