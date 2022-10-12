<?php
namespace App\Views;
?>

<?php include "header.php"; ?>

<form class="user-form" action="/checkUser" method="post">
    <caption>Login form</caption>
    <?php if (isset($_SESSION['loginError'])):?>
        <div style="color:red">Incorrect information</div>
    <?php endif ?>
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
        <input id="email" name="email" type="email" oninput="checkValidation()" required>
    </div>

    <button id="registerButton" class="btn btn-primary" disabled>Login</button>
</form>

<script type="text/javascript" src="/js/register.js"></script>

<?php include "footer.php" ?>
