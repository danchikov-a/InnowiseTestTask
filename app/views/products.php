<?php include "header.php"; ?>

<table class="table table-bordered table-hover">
    <caption>Television list</caption>
    <thead class="thead-dark">
    <tr>
        <th scope="col">Name</th>
        <th scope="col">Manufacture</th>
        <th scope="col">Release date</th>
        <th scope="col">Cost</th>
        <th scope="col">Add to cart</th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($products as $product): ?>

        <tr>
            <td><a href="products/<?= $product->getId() ?>"><?= $product->getName() ?></a></td>
            <td><?= $product->getManufacture() ?></td>
            <td><?= $product->getReleaseDate() ?></td>
            <td><?= $product->getCost() ?></td>
            <td>
                <a class="btn btn-outline-success"
                   href="products/<?= $product->getId() ?>">Add</a>
            </td>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>

<?php include "footer.php"; ?>
