<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../../public/css/user.css">
</head>
<body>
<form class="user-form" action="add.php" method="post">

    <div class="form-group form-element">
        <label>First and last name</label>
        <input name="name" type="text">
    </div>
    <div class="form-group form-element">
    <label>Email</label>
    <?php
    //TODO validation
    if (isset($_SESSION['email_error'])) {
        echo "Error";
    }
    ?>

    <input name="email" type="email">
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

        use src\Router;

        require "../Router.php";

        $router = new Router("UserController", "all");
        $router->route();

        foreach ($_GET["users"] as $user): ?>

        <td><?php echo $user->Name ?></td>
        <td><?php echo $user->Email ?></td>
        <td><?php echo $user->Gender ?></td>
        <td><?php echo $user->Status ?></td>
        <td>
            <form action="updateForm.php" method="post">
                <input name="updateName" value="<?php echo $user->Name ?>" hidden>
                <input name="updateEmail" value="<?php echo $user->Email ?>" hidden>
                <input name="updateGender" value="<?php echo $user->Gender ?>" hidden>
                <input name="updateStatus" value="<?php echo $user->Status ?>" hidden>
                <button class="btn btn-outline-dark">Update</button>
            </form>
        </td>
        <td>
            <form action="delete.php" method="post" onclick="deleteConfirmation()">
                <input name="deleteEmail" value="<?php echo $user->Email ?>" hidden>
                <button class="btn btn btn-outline-danger" id="deleteButton">Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>

    </tbody>
</table>

<script type="text/javascript" src="../../public/js/confirm-delete.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>