<?php
namespace App\Views;
?>

<?php include dirname(__DIR__, 2) . "/public/templates/header.html" ?>

<form class="user-form" action="/index.php?controller=UserController&action=update" method="post">
    <caption>User form update</caption>
    <div class="form-group form-element">
        <label>First and last name</label>
        <input name="name" type="text" value="<?php echo $_POST['updateName']?>" required>
    </div>
    <div class="form-group form-element">
        <label>Email</label>
        <?php

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
<?php include dirname(__DIR__, 2) . "/public/templates/footer.html" ?>

</body>
</html>