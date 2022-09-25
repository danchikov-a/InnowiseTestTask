<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User form</title>
</head>
<body>
<form action="add.php" method="post">
    <label>First and last name</label>
    <input name="name" type="text">

    <label>Email</label>
    <?php
    //TODO validation
    if (isset($_SESSION['email_error'])) {
        echo "Error";
    }
    ?>
    <input name="email" type="email">

    <label>Gender</label>
    <select name="gender">
        <option value="male">Male</option>
        <option value="female">Female</option>
    </select>

    <label>Status</label>
    <select name="status">
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
    </select>

    <button>Add user</button>
</form>

<?php

use src\Router;

require "../Router.php";

$router = new Router("UserController", "all");
$router->route();

foreach ($_GET["users"] as $user): ?>
    <div>
        <?php echo $user->Name ?>
        <?php echo $user->Email ?>
        <?php echo $user->Gender ?>
        <?php echo $user->Status ?>
        <form action="delete.php" method="post" onclick="deleteConfirmation()">
            <input name="deleteEmail" value="<?php echo $user->Email ?>" hidden>
            <button id="deleteButton">Delete</button>
        </form>
    </div>
<?php endforeach; ?>
<script type="text/javascript" src="../../public/js/confirm-delete.js"></script>
</body>
</html>