<?php
namespace App\Views;
?>

<?php include "header.php"; ?>

<form class="user-form" action="/cart/checkout" method="post">
    <div class="form-group form-element">
        <label>Name</label>
        <input name="name" type="text" required>
    </div>
    <div class="form-group form-element">
        <label>Phone</label>
        <input name="phone" type="text" required>
    </div>

    <div class="form-group form-element">
        <label>Address</label>
        <input name="address" type="text" required>
    </div>

    <button class="btn btn-primary">Checkout</button>
</form>
<?php include "footer.php" ?>
