<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User form</title>
</head>
<body>
    <form action="../../index.php" method="post">
        <label>First and last name</label>
        <input name="name" type="text">

        <label>Email</label>
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

    <?php foreach($_GET['users'] as $user): ?>
        <div>
        <?php echo $user->Name ?>
        <?php echo $user->Email ?>
        <?php echo $user->Gender ?>
        <?php echo $user->Status ?>
        </div>
    <?php endforeach; ?>
</body>
</html>