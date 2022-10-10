<?php
namespace App\Views;
?>

<?php use App\Controllers\FileController;

include dirname(__DIR__, 2) . "/public/templates/header.html";
$fileController = new FileController();
$fileController->all();
?>

<form action="/index.php?controller=FileController&action=create" class="user-form" method="post" enctype="multipart/form-data" onSubmit="return validateFile()">
    <div>
        <div class="form-group form-element">
            <label for="file">Choose file to upload</label>
        </div>
        <div class="form-group form-element">
            <?php
            if (isset($_SESSION['file_error'])):?>
                <div style="color:red">Not enough storage space</div>
            <?php endif ?>
            <input name="file" type="file" id="file" required>
        </div>
    </div>
    <div>
        <button class="btn btn-primary">Submit</button>
    </div>
</form>

<table class="table table-bordered table-hover">
    <caption>File list</caption>
    <thead class="thead-dark">
    <tr>
        <th scope="col">File name</th>
        <th scope="col">File size</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <?php

        foreach ($_GET["files"] as $file): ?>

        <td><?php echo $file->getFileName() ?></td>
        <td><?php echo $file->getFileSize() ?></td>
    </tr>
    <?php endforeach; ?>

    </tbody>
</table>


<script type="text/javascript" src="/js/validate-file.js"></script>

<?php include dirname(__DIR__, 2) . "/public/templates/footer.html" ?>
