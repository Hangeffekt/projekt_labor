<?php
    if (!isset($_GET['id'])) {
        echo "<h2>404 - Az oldal nem található</h2>";
        exit;
    }
    $id = preg_replace('/[^0-9]/', '', $_GET['id']);
    $data = product_details($id);
    $product = $data["product"];
?>

<?php include('error.php'); ?>

<?php
    if (empty($product)): ?>
        Nincs megjeleníthető termék!
    <?php else: ?>
        <div class="card" style="width: 18rem;">
            <img src="<?= $product['image'] ?>" class="card-img-top" alt="<?= $product['product_name'] ?>">
            <div class="card-body">
                <h5 class="card-title"><?= $product['brand_name'] ?> <?= $product['product_name'] ?></h5>
                <p class="card-text"><?= $product['sale_price'] ?></p>
                <p class="card-text"><?= $product['tax_value'] ?>%</p>
                <p class="card-text"><?= $product['description'] ?></p>
                <form method="post">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <button type="submit" class="btn btn-success" name="add_to_cart">Kosárba</button>
            </div>
        </div>

    <?php endif; ?>