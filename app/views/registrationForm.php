<?php
namespace App\Views;
?>

<?php include "header.php"; ?>

<form class="user-form" action="/register" method="post">
    <caption>Register form</caption>
    <div class="form-group form-element">
        <label>First and last name</label>
        <input name="name" type="text" id="name" oninput="checkValidation()" required>
    </div>
    <div class="form-group form-element">
        <label>Password</label>
        <input name="password" type="password" id="password" oninput="checkValidation()" required>
    </div>
    <div class="form-group form-element">
        <label>Email</label>
        <?php

        if (isset($_SESSION['email_error'])):?>
            <div style="color:red">Not unique email</div>
        <?php endif ?>
        <input id="email" name="email" type="email" oninput="checkValidation()" required>
    </div>

    <div class="form-group form-element">
        <label>Gender</label>
        <select class="custom-select user-select" name="gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>
    </div>

    <button id="registerButton" class="btn btn-primary" disabled>Register</button>
</form>

<script type="text/javascript" src="/js/register.js"></script>

<?php include "footer.php" ?>
