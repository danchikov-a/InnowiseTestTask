<?php
namespace App\Views;
?>

<?php include "header.php" ?>

<form class="user-form" action="/add" method="post">
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
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Gender</th>
        <th scope="col">Status</th>
        <th scope="col">Update</th>
        <th scope="col">Delete</th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($_GET["users"] as $user): ?>
        <tr>
            <td><?= $user->Name ?></td>
            <td><?= $user->Email ?></td>
            <td><?= $user->Gender ?></td>
            <td><?= $user->Status ?></td>
            <td>
                <form action="/updateForm" method="post">
                    <input name="updateName" value="<?= $user->Name ?>" hidden>
                    <input name="updateEmail" value="<?= $user->Email ?>" hidden>
                    <input name="updateGender" value="<?= $user->Gender ?>" hidden>
                    <input name="updateStatus" value="<?= $user->Status ?>" hidden>
                    <button class="btn btn-outline-dark">Update</button>
                </form>
            </td>
            <td>
                <form action="/delete" method="post"
                      onclick="return deleteConfirmation()">
                    <input name="deleteEmail" value="<?= $user->Email ?>" hidden>
                    <button class="btn btn btn-outline-danger" id="deleteButton">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>
<?php include "footer.php" ?>

<script type="text/javascript" src="/js/confirm-delete.js"></script>
