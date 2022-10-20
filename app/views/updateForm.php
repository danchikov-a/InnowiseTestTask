<?php
namespace App\Views;
?>

<?php include "header.php" ?>
<?php $user = $_GET["user"] ?>

<form class="user-form" action="/update/<?= $user->Id?>" method="post">
    <caption>User form update</caption>
    <div class="form-group form-element">
        <label>First and last name</label>
        <input name="name" type="text" value="<?= $user->Name?>" required>
    </div>
    <div class="form-group form-element">
        <label>Email</label>
        <?php

        if (isset($_SESSION['email_error'])):?>
            <div style="color:red">Not unique email</div>
        <?php endif?>
        <input id="email" name="email" type="email" value="<?= $user->Email?>" required>
    </div>

    <div class="form-group form-element">
        <label>Gender</label>
        <select class="custom-select user-select" name="gender">
            <option value="male" <?php if ($user->Gender == 'male') { echo ' selected="selected"'; } ?>>Male</option>
            <option value="female" <?php if ($user->Gender == 'female') { echo ' selected="selected"'; } ?>>Female</option>
        </select>
    </div>
    <div class="form-group form-element">
        <label>Status</label>
        <select class="custom-select user-select" name="status">
            <option value="active" <?php if ($user->Status == 'active') { echo ' selected="selected"'; } ?>>Active</option>
            <option value="inactive" <?php if ($user->Status == 'inactive') { echo ' selected="selected"'; } ?>>Inactive</option>
        </select>
    </div>

    <button class="btn btn-primary">Update user</button>
</form>
<?php include "footer.php" ?>

</body>
</html>