<?php
    $data = $_SESSION["cart_data"] ?? [];
    $carts = $data["cart"] ?? [];
    $total = 0;

    if (isset($_POST['update_cart'])) {

        $cart_id = $_POST['cart_id'] ?? 0;
        $quantity = (int)($_POST['quantity'] ?? 1);

        if ($quantity < 1) {
            $quantity = 1;
        }

        foreach ($carts as &$cart) {
            if ($cart["id"] == $cart_id) {
                $cart["quantity"] = $quantity;
                break;
            }
        }

        unset($cart);

        $_SESSION["cart_data"]["cart"] = $carts;

        header("Location: index.php?page=cart&success=5");
        exit;
    }


    if (isset($_POST['remove_from_cart'])) {

        $cart_id = $_POST['cart_id'] ?? 0;

        foreach ($carts as $key => $cart) {
            if ($cart["id"] == $cart_id) {
                unset($carts[$key]);
                break;
            }
        }

        $_SESSION["cart_data"]["cart"] = array_values($carts);

        header("Location: index.php?page=cart&success=6");
        exit;
    }
?>

<?php include('error.php'); ?>

<div class="cart-page">

    <div class="cart-page-header">
        <div>
            <h1 class="cart-page-title">Kosár</h1>
        </div>
    </div>

    <?php if (!empty($carts)): ?>
        <div class="cart-layout">
            <div class="cart-products">
                <?php foreach ($carts as $cart):
                    $product_data = product_details($cart["id"]);
                    $product = $product_data["product"] ?? [];

                    if (empty($product)) {
                        continue;
                    }

                    $item_total = $product["sale_price"] * $cart["quantity"];
                    $total += $item_total;
                ?>

                    <div class="cart-item">

                        <!-- IMAGE -->

                        <a
                            href="index.php?page=product&id=<?= $product['id'] ?>"
                            class="cart-item-image"
                        >
                            <img
                                src="<?= htmlspecialchars($product["image"]) ?>"
                                alt="<?= htmlspecialchars($product["product_name"]) ?>"
                            >
                        </a>

                        <div class="cart-item-info">
                            <div class="cart-item-brand">
                                <?= htmlspecialchars($product["brand_name"]) ?>
                            </div>
                            <a
                                href="index.php?page=product&id=<?= $product['id'] ?>"
                                class="cart-item-name">
                                <?= htmlspecialchars($product["product_name"]) ?>
                            </a>
                            <div class="cart-item-unit-price">
                                <?= htmlspecialchars($product["sale_price"]) ?> Ft / db
                            </div>
                        </div>
                        <div class="cart-item-quantity">
                            <span class="cart-item-label">
                                Mennyiség
                            </span>
                            <form method="post" class="cart-update-form">
                                <input
                                    type="hidden"
                                    name="cart_id"
                                    value="<?= $cart["id"] ?>">
                                <input
                                    type="number"
                                    name="quantity"
                                    value="<?= $cart["quantity"] ?>"
                                    min="1"
                                    class="cart-quantity-input">
                                <button
                                    type="submit"
                                    name="update_cart"
                                    class="cart-update-button"
                                    title="Mennyiség frissítése">
                                    <i class="bi bi-check2"></i>
                                </button>
                            </form>
                        </div>

                        <div class="cart-item-total">
                            <span class="cart-item-label">
                                Összesen
                            </span>
                            <strong>
                                <?= $item_total ?> Ft
                            </strong>
                        </div>

                        <form method="post" class="cart-remove-form">
                            <input
                                type="hidden"
                                name="cart_id"
                                value="<?= $cart["id"] ?>">
                            <button
                                type="submit"
                                name="remove_from_cart"
                                class="cart-remove-button"
                                title="Eltávolítás">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>

            <aside class="cart-summary">
                <h2>Összegzés</h2>
                <div class="cart-summary-row">
                    <span>Termékek összesen</span>
                    <strong><?= $total ?> Ft</strong>
                </div>
                <div class="cart-summary-row">
                    <span>Szállítás</span>
                    <strong>-</strong>
                </div>
                <div class="cart-summary-divider"></div>
                <div class="cart-summary-total">
                    <span>Végösszeg</span>
                    <strong><?= $total ?> Ft</strong>
                </div>
                <a
                    href="index.php?page=delivery"
                    class="checkout-button">
                    Tovább a szállításhoz
                    <i class="bi bi-arrow-right"></i>
                </a>
                <a
                    href="index.php?page=main"
                    class="continue-shopping-button">
                    <i class="bi bi-arrow-left"></i>
                    Vásárlás folytatása
                </a>
            </aside>
        </div>

    <?php else: ?>
        <div class="empty-cart">
            <div class="empty-cart-icon">
                <i class="bi bi-cart"></i>
            </div>
            <h2>A kosár üres</h2>
            <p>
                Még nincs termék a kosaradban
            </p>
            <a
                href="index.php?page=main"
                class="checkout-button empty-cart-button">
                Vásárlás megkezdése
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    <?php endif; ?>
</div>