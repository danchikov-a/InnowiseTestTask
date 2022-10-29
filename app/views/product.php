<?php include "header.php"; ?>
<?php if ($product) : ?>
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Manufacture</th>
            <th scope="col">Release date</th>
            <th scope="col">Cost</th>
        </tr>
        </thead>
        <tbody>

        <tr>
            <td><?= $product->getName() ?></a></td>
            <td><?= $product->getManufacture() ?></td>
            <td><?= $product->getReleaseDate() ?></td>
            <td><?= $product->getCost() ?></td>
        </tr>

        </tbody>
    </table>

    <table class="table table-bordered table-hover">
        <caption>Television list</caption>
        <thead class="thead-dark">
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Deadline</th>
            <th scope="col">Cost</th>
            <th scope="col">Add</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($services as $service): ?>
            <tr>
                <td><a href="../services/<?= $service->getId() ?>"><?= $service->getName() ?></a></td>
                <td><?= $service->getDeadLine() ?></td>
                <td><?= $service->getCost() ?></td>
                <td>
                    <?php if (!isset($_SESSION[$service->getName()])):?>
                        <form class="btn btn-outline-success"
                              action="<?= $product->getId()?>/services/<?= $service->getId() ?>" method="post">
                            <button>+</button>
                        </form>
                    <?php else: ?>
                        <form class="btn btn-outline-danger"
                              action="<?= $product->getId()?>/services/delete/<?= $service->getId() ?>" method="post">
                            <button>-</button>
                        </form>
                    <?php endif;?>
                </td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
    <div>Total cost: <?= $totalCost?></div>
    <form class="btn btn-outline-success" action="<?= $product->getId()?>/addToCart" method="post">
        <button>Add to cart</button>
    </form>
<?php else: ?>
    <div>No such product</div>
<?php endif; ?>
<?php include "footer.php"; ?>
