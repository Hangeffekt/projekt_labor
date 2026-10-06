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
    include "breadcrumb.php";

    if (empty($product)): ?>

        <div class="product-not-found">
            Nincs megjeleníthető termék!
        </div>

    <?php else: ?>

        <div class="product-page">

            <!-- PRODUCT IMAGE -->
            <div class="product-page-image">

                <div class="product-page-image-box">
                    <img
                        src="<?= htmlspecialchars($product['image']) ?>"
                        alt="<?= htmlspecialchars($product['product_name']) ?>"
                    >
                </div>

            </div>


            <!-- PRODUCT INFORMATION -->
            <div class="product-page-info">

                <div class="product-page-brand">
                    <?= htmlspecialchars($product['brand_name']) ?>
                </div>

                <h1 class="product-page-title">
                    <?= htmlspecialchars($product['product_name']) ?>
                </h1>

                <div class="product-page-price">
                    <?= htmlspecialchars($product['sale_price']) ?> Ft
                </div>

                <div class="product-page-tax">
                    ÁFA: <?= htmlspecialchars($product['tax_value']) ?>%
                </div>

                <div class="product-page-divider"></div>

                <div class="product-page-description">
                    <?= nl2br(htmlspecialchars($product['description'])) ?>
                </div>

                <form method="post" class="product-page-cart-form">

                    <input
                        type="hidden"
                        name="product_id"
                        value="<?= $product['id'] ?>"
                    >

                    <button
                        type="submit"
                        class="product-page-cart-button"
                        name="add_to_cart"
                    >
                        <i class="bi bi-cart"></i>
                        Kosárba
                    </button>

                </form>

            </div>

        </div>

    <?php endif; ?>