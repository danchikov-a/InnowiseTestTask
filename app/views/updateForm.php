<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update user</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../../public/css/user.css">
</head>
<body>

<form class="user-form" action="update.php" method="post">
    <caption>User form update</caption>
    <div class="form-group form-element">
        <label>First and last name</label>
        <input name="name" type="text" value="<?php echo $_POST['updateName']?>" required>
    </div>
    <div class="form-group form-element">
        <label>Email</label>
        <?php
        session_start();
        if (isset($_SESSION['email_error'])):?>
            <div style="color:red">Not unique email</div>
        <?php endif?>
        <input id="email" name="email" type="email" value="<?php echo $_POST['updateEmail']?>" required>
        <input name="oldEmail" type="email" value="<?php echo $_POST['updateEmail']?>" hidden>
    </div>

    <div class="form-group form-element">
        <label>Gender</label>
        <select class="custom-select user-select" name="gender">
            <option value="male" <?php if ($_POST['updateGender'] == 'male') { echo ' selected="selected"'; } ?>>Male</option>
            <option value="female" <?php if ($_POST['updateGender'] == 'female') { echo ' selected="selected"'; } ?>>Female</option>
        </select>
    </div>
    <div class="form-group form-element">
        <label>Status</label>
        <select class="custom-select user-select" name="status">
            <option value="active" <?php if ($_POST['updateStatus'] == 'active') { echo ' selected="selected"'; } ?>>Active</option>
            <option value="inactive" <?php if ($_POST['updateStatus'] == 'inactive') { echo ' selected="selected"'; } ?>>Inactive</option>
        </select>
    </div>

    <button class="btn btn-primary">Update user</button>
</form>
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