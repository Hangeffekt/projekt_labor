<?php
    $data = $_SESSION["cart_data"] ?? [];
    $carts = $data["cart"];
    $total = 0;

    if (isset($_POST['update_cart'])) {
        $cart_id = $_POST['cart_id'];
        $quantity = $_POST['quantity'];

        foreach ($carts as &$cart) {
            if ($cart["id"] == $cart_id) {
                $cart["quantity"] = $quantity;
                break;
            }
        }

        $_SESSION["cart_data"]["cart"] = $carts;
        header("Location: index.php?page=cart&success=5");
    }

    if (isset($_POST['remove_from_cart'])) {
        $cart_id = $_POST['cart_id'];

        foreach ($carts as $key => $cart) {
            if ($cart["id"] == $cart_id) {
                unset($carts[$key]);
                break;
            }
        }

        $_SESSION["cart_data"]["cart"] = array_values($carts);
        header("Location: index.php?page=cart&success=6");
    }
?>

<?php include('error.php'); ?>

<div class="cart-page">

    <h2 class="page-title">Kosár</h2>

    <?php if(!empty($carts)): ?>

        <div class="cart-layout">

            <div class="cart-products">

                <?php foreach($carts as $cart): 
                    $product = product_details($cart["id"]);
                    $product = $product["product"];
                    $total += $product["sale_price"] * $cart["quantity"];
                ?>
                    <div class="cart-item">
                        <div class="cart-item-image">
                            <img src="<?= $product["image"]; ?>" 
                                 alt="<?= $product["product_name"]; ?>">
                        </div>
                        <div class="cart-item-info">
                            <h3><?= $product["brand_name"]; ?> <?= $product["product_name"]; ?></h3>
                            <p class="cart-item-price">
                                <?= $product["sale_price"]; ?> Ft
                            </p>
                            <p class="cart-item-quantity">
                                Mennyiség: <?= $cart["quantity"]; ?> db
                            </p>
                        </div>
                        <div class="cart-item-actions">
                            <form method="post" class="cart-update-form">
                                <input type="hidden" name="cart_id" value="<?= $cart["id"]; ?>">
                                <input type="number" 
                                       name="quantity" 
                                       value="<?= $cart["quantity"]; ?>" 
                                       min="1">
                                <button type="submit" name="update_cart">
                                    Frissítés
                                </button>
                            </form>
                            <form method="post">
                                <input type="hidden" name="cart_id" value="<?= $cart["id"]; ?>">
                                <button type="submit" name="remove_from_cart" class="remove-button">
                                    <i class="bi bi-trash"></i> Eltávolítás
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="cart-summary">
                <h3>Összegzés</h3>
                <div class="cart-summary-row">
                    <span>Termékek összesen</span>
                    <strong><?= $total; ?> Ft</strong>
                </div>
                <div class="cart-summary-total">
                    <span>Végösszeg</span>
                    <strong><?= $total; ?> Ft</strong>
                </div>
                <a href="index.php?page=delivery" class="checkout-button">
                    Tovább a szállításhoz
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

    <?php else: ?>
        <div class="empty-cart">
            <h3>A kosár üres</h3>
            <p>Válassz egy terméket a vásárlói oldalon.</p>
            <a href="index.php?page=main" class="continue-shopping-button">
                Vissza a főoldalra
            </a>
        </div>

    <?php endif; ?>
</div>