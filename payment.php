<?php
    $data = $_SESSION["cart_data"] ?? [];
    $carts = $data["cart"];
    $data = $_SESSION["delivery_data"] ?? [];
    $delivery = $data;
    $total = 0;

    if (empty($carts)) {
        header("Location: index.php?page=cart&error=8");
        exit;
    }

    if (empty($delivery)) {
        header("Location: index.php?page=delivery&error=9");
        exit;
    }

    if(isset($_POST['submit_payment'])) {
        save_cart_data($_SESSION["cart_data"]);
        save_delivery_data($_SESSION["delivery_data"]);
        unset($_SESSION["cart_data"]);
        unset($_SESSION["delivery_data"]);

        header("Location: index.php?page=success");
        exit;
    }
?>

<div class="payment-page">
    <h2 class="page-title">Rendelés összesítése</h2>
    <div class="payment-layout">
        <div class="payment-main">
            <div class="payment-section">
                <h3>
                    <i class="bi bi-bag"></i>
                    Megrendelt termékek
                </h3>
                <?php foreach($carts as $cart): 
                    $product = product_details($cart["id"]);
                    $product = $product["product"];
                    $total += $product["sale_price"] * $cart["quantity"];
                ?>
                    <div class="payment-product">
                        <div class="payment-product-image">
                            <img src="<?= $product["image"]; ?>" 
                                 alt="<?= $product["product_name"]; ?>">
                        </div>
                        <div class="payment-product-info">
                            <h4><?= $product["brand_name"]; ?> <?= $product["product_name"]; ?></h4>
                            <p><?= $product["sale_price"]; ?> Ft / db</p>
                            <span>Mennyiség: <?= $cart["quantity"]; ?> db</span>
                        </div>
                        <strong class="payment-product-total">
                            <?= $product["sale_price"] * $cart["quantity"]; ?> Ft
                        </strong>
                    </div>
                <?php endforeach; ?>
                <div class="payment-total">
                    <span>Végösszeg</span>
                    <strong><?= $total; ?> Ft</strong>
                </div>
            </div>

            <div class="payment-section">
                <h3>
                    <i class="bi bi-truck"></i>
                    Szállítási adatok
                </h3>
                <div class="payment-info-grid">
                    <div class="payment-info-item">
                        <span>Név</span>
                        <strong><?= $delivery["vezeteknev"] ?> <?= $delivery["keresztnev"] ?></strong>
                    </div>
                    <div class="payment-info-item">
                        <span>Email</span>
                        <strong><?= $delivery["email"] ?></strong>
                    </div>
                    <div class="payment-info-item">
                        <span>Telefonszám</span>
                        <strong><?= $delivery["telefonszam"] ?></strong>
                    </div>
                    <div class="payment-info-item">
                        <span>Cím</span>
                        <strong><?= $delivery["irsz"] ?> <?= $delivery["cim"] ?></strong>
                    </div>
                </div>
            </div>

            <div class="payment-section">
                <h3>
                    <i class="bi bi-receipt"></i>
                    Számlázási adatok
                </h3>
                <?php if($delivery["invoice"]): ?>
                    <div class="payment-info-grid">
                        <div class="payment-info-item">
                            <span>Név</span>
                            <strong><?= $delivery["name"] ?></strong>
                        </div>
                        <div class="payment-info-item">
                            <span>Adószám</span>
                            <strong><?= $delivery["tax_number"] ?></strong>
                        </div>
                        <div class="payment-info-item">
                            <span>Cím</span>
                            <strong><?= $delivery["invoice_irsz"] ?> <?= $delivery["invoice_cim"] ?></strong>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="payment-info-grid">
                        <div class="payment-info-item">
                            <span>Név</span>
                            <strong><?= $delivery["vezeteknev"] ?> <?= $delivery["keresztnev"] ?></strong>
                        </div>
                        <div class="payment-info-item">
                            <span>Cím</span>
                            <strong><?= $delivery["irsz"] ?> <?= $delivery["cim"] ?></strong>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="payment-summary">
            <h3>Rendelés összesítése</h3>
            <div class="payment-summary-row">
                <span>Termékek összesen</span>
                <strong><?= $total; ?> Ft</strong>
            </div>
            <div class="payment-summary-total">
                <span>Fizetendő összeg</span>
                <strong><?= $total; ?> Ft</strong>
            </div>
            <form method="post" action="index.php?page=payment">
                <button type="submit" name="submit_payment" class="payment-button">
                    <i class="bi bi-check-circle"></i>
                    Fizetés
                </button>
            </form>
            <a href="index.php?page=delivery" class="back-button">
                <i class="bi bi-arrow-left"></i>
                Vissza a szállításhoz
            </a>
        </div>
    </div>
</div>