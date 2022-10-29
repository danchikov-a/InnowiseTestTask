<?php include "header.php"; ?>

<table class="table table-bordered table-hover">
    <thead class="thead-dark">
    <tr>
        <th scope="col">Name</th>
        <th scope="col">Manufacture</th>
        <th scope="col">Release date</th>
        <th scope="col">Services</th>
        <th scope="col">Cost</th>
        <th scope="col">Delete from cart</th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($products as $product): ?>

        <tr>
            <td><a href="products/<?= $product->getId() ?>"><?= $product->getName() ?></a></td>
            <td><?= $product->getManufacture() ?></td>
            <td><?= $product->getReleaseDate() ?></td>
            <td>
                <?php foreach ($_SESSION["cart"][$product->getId()] as $service) : ?>
                    <div><?= $service ?></div>
                <?php endforeach; ?>
            </td>
            <td><?= $product->getCost() ?></td>
            <td>
                <form class="btn btn-outline-danger" action="cart/<?= $product->getId() ?>/deleteFromCart"
                      method="post">
                    <button>Delete from cart</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div>Total cost with all services: <?= $totalCost ?></div>
<a href="cart/checkout">Checkout</a>
<?php include "footer.php"; ?>
