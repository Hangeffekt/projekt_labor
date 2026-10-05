<?php
$productImage = !empty($product['image'])
    ? $product['image']
    : 'assets/dumy.png';
?>

<div class="shop-item-card">
    <div class="shop-item-image-area">
        <a
            href="index.php?page=product&id=<?= (int)$product['id'] ?>"
            class="shop-item-image-link">
            <div class="shop-item-image-box">
                <img
                    src="<?= htmlspecialchars($productImage) ?>"
                    alt="<?= htmlspecialchars($product['product_name']) ?>"
                    class="shop-item-image"
                    onerror="this.onerror=null; this.src='assets/dumy.png';">
                <span class="shop-item-details-icon">
                    <i class="bi bi-arrow-up-right"></i>
                </span>
            </div>
        </a>
    </div>

    <div class="shop-item-content">
        <h5 class="shop-item-name">
            <a
                href="index.php?page=product&id=<?= (int)$product['id'] ?>"
                class="shop-item-name-link">
                <?= htmlspecialchars($product['product_name']) ?>
            </a>
        </h5>
        <div class="shop-item-price">
            <?= htmlspecialchars($product['sale_price']) ?> Ft
        </div>
        <a
            href="index.php?page=product&id=<?= (int)$product['id'] ?>"
            class="shop-item-details">
            Részletek
        </a>
        <form method="post" class="shop-item-cart-form">
            <input
                type="hidden"
                name="product_id"
                value="<?= (int)$product['id'] ?>">

                <button type="submit"
                    class="shop-item-cart-button"
                    name="add_to_cart"
                    title="Kosárba">
                    <i class="bi bi-cart-plus"></i>
                </button>
        </form>
    </div>
</div>