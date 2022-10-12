<?php
namespace App\Views;

if(!isset($_COOKIE['userName'])) {
    header("Location: /login");
}
?>

<?php include "header.php"; ?>
<div>
    Welcome <?=$_COOKIE['userName']?>
</div>
<?php include "footer.php" ?>
