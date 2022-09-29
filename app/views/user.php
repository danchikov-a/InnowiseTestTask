<?php
namespace App\Views;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User form</title>

    <link rel="stylesheet" href="user.css" type="text/css">
    <link rel="stylesheet" href="bootstrap.min.css" type="text/css">
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/public/templates/header.html" ?>

<form class="user-form" action="add" method="post">
    <caption>User form</caption>
    <div class="form-group form-element">
        <label>First and last name</label>
        <input name="name" type="text" required>
    </div>
    <div class="form-group form-element">
        <label>Email</label>
        <?php

        if (isset($_SESSION['email_error'])):?>
            <div style="color:red">Not unique email</div>
        <?php endif ?>
        <input id="email" name="email" type="email" required>
    </div>

    <div class="form-group form-element">
        <label>Gender</label>
        <select class="custom-select user-select" name="gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>
    </div>
    <div class="form-group form-element">
        <label>Status</label>
        <select class="custom-select user-select" name="status">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>

    <button class="btn btn-primary">Add user</button>
</form>


<table class="table table-bordered table-hover">
    <caption>User list</caption>
    <thead class="thead-dark">
    <tr>
        <th scope="col">Email</th>
        <th scope="col">Name</th>
        <th scope="col">Gender</th>
        <th scope="col">Status</th>
        <th scope="col">Update</th>
        <th scope="col">Delete</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <?php

        use App\Router;

        $router = new Router("UserController", "all");
        $router->route();

        foreach ($_GET["users"] as $user): ?>

        <td><?php echo $user->Name ?></td>
        <td><?php echo $user->Email ?></td>
        <td><?php echo $user->Gender ?></td>
        <td><?php echo $user->Status ?></td>
        <td>
            <form action="updateForm" method="post">
                <input name="updateName" value="<?php echo $user->Name ?>" hidden>
                <input name="updateEmail" value="<?php echo $user->Email ?>" hidden>
                <input name="updateGender" value="<?php echo $user->Gender ?>" hidden>
                <input name="updateStatus" value="<?php echo $user->Status ?>" hidden>
                <button class="btn btn-outline-dark">Update</button>
            </form>
        </td>
        <td>
            <form action="delete" method="post" onclick="return deleteConfirmation()">
                <input name="deleteEmail" value="<?php echo $user->Email ?>" hidden>
                <button class="btn btn btn-outline-danger" id="deleteButton">Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>

    </tbody>
</table>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/public/templates/footer.html" ?>

<script type="text/javascript" src="/confirm-delete.js"></script>
<script src="public/js/index.js"></script>

</body>
</html>