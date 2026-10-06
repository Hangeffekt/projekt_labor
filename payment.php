<?php
    $cart_data = $_SESSION["cart_data"] ?? [];
    $carts = $cart_data["cart"] ?? [];

    $delivery = $_SESSION["delivery_data"] ?? [];

    $total = 0;

    if (empty($carts)) {
        header("Location: index.php?page=cart&error=8");
        exit;
    }


    if (empty($delivery)) {
        header("Location: index.php?page=delivery&error=9");
        exit;
    }


    if (isset($_POST['submit_payment'])) {

        save_cart_data($_SESSION["cart_data"]);
        save_delivery_data($_SESSION["delivery_data"]);

        unset($_SESSION["cart_data"]);
        unset($_SESSION["delivery_data"]);

        header("Location: index.php?page=success");
        exit;
    }
?>


<div class="checkout-page">
    <div class="checkout-header">
        <div>
            <h1>Rendelés összesítése</h1>
            <p class="checkout-header-subtitle">
                Ellenőrizd az adatokat a rendelés leadása előtt.
            </p>
        </div>
        <div class="checkout-steps">
            <div class="checkout-step completed">
                <span>
                    <i class="bi bi-check"></i>
                </span>
                <strong>Szállítás</strong>
            </div>
            <div class="checkout-step-line active"></div>
            <div class="checkout-step active">
                <span>2</span>
                <strong>Összesítés</strong>
            </div>
        </div>
    </div>

    <div class="checkout-layout">
        <div class="checkout-main">
            <section class="checkout-section">
                <div class="checkout-section-header">
                    <div class="checkout-section-icon">
                        <i class="bi bi-bag"></i>
                    </div>
                    <div>
                        <h2>Megrendelt termékek</h2>
                        <p>Ezeket a termékeket rendelted meg.</p>
                    </div>
                </div>
                <div class="review-products">
                    <?php foreach ($carts as $cart):
                        $product_data = product_details($cart["id"]);
                        $product = $product_data["product"] ?? [];
                        if (empty($product)) {
                            continue;
                        }
                        $item_total = $product["sale_price"] * $cart["quantity"];
                        $total += $item_total;
                    ?>
                        <div class="review-product">
                            <div class="review-product-image">
                                <img
                                    src="<?= htmlspecialchars($product["image"]) ?>"
                                    alt="<?= htmlspecialchars($product["product_name"]) ?>">
                            </div>
                            <div class="review-product-info">
                                <span class="review-product-brand">
                                    <?= htmlspecialchars($product["brand_name"]) ?>
                                </span>
                                <strong class="review-product-name">
                                    <?= htmlspecialchars($product["product_name"]) ?>
                                </strong>
                                <span class="review-product-quantity">
                                    <?= $cart["quantity"] ?> db ×
                                    <?= $product["sale_price"] ?> Ft
                                </span>
                            </div>
                            <strong class="review-product-total">
                                <?= $item_total ?> Ft
                            </strong>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <section class="checkout-section">
                <div class="checkout-section-header">
                    <div class="checkout-section-icon">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div>
                        <h2>Szállítási adatok</h2>
                    </div>
                </div>
                <div class="review-info-grid">
                    <div class="review-info-item">
                        <span>Név</span>
                        <strong>
                            <?= htmlspecialchars($delivery["vezeteknev"]) ?>
                            <?= htmlspecialchars($delivery["keresztnev"]) ?>
                        </strong>
                    </div>
                    <div class="review-info-item">
                        <span>Email</span>
                        <strong>
                            <?= htmlspecialchars($delivery["email"]) ?>
                        </strong>
                    </div>
                    <div class="review-info-item">
                        <span>Telefonszám</span>
                        <strong>
                            <?= htmlspecialchars($delivery["telefonszam"]) ?>
                        </strong>
                    </div>
                    <div class="review-info-item">
                        <span>Szállítási cím</span>
                        <strong>
                            <?= htmlspecialchars($delivery["irsz"]) ?>
                            <?= htmlspecialchars($delivery["cim"]) ?>
                        </strong>
                    </div>
                </div>
            </section>

            <section class="checkout-section">
                <div class="checkout-section-header">
                    <div class="checkout-section-icon">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div>
                        <h2>Számlázási adatok</h2>
                    </div>
                </div>
                <div class="review-info-grid">
                    <?php if (!empty($delivery["invoice"])): ?>
                        <div class="review-info-item">
                            <span>Név</span>
                            <strong>
                                <?= htmlspecialchars($delivery["name"]) ?>
                            </strong>
                        </div>
                        <div class="review-info-item">
                            <span>Adószám</span>
                            <strong>
                                <?= htmlspecialchars($delivery["tax_number"]) ?>
                            </strong>
                        </div>
                        <div class="review-info-item">
                            <span>Számlázási cím</span>
                            <strong>
                                <?= htmlspecialchars($delivery["invoice_irsz"]) ?>
                                <?= htmlspecialchars($delivery["invoice_cim"]) ?>
                            </strong>
                        </div>
                    <?php else: ?>
                        <div class="review-info-item">
                            <span>Név</span>
                            <strong>
                                <?= htmlspecialchars($delivery["vezeteknev"]) ?>
                                <?= htmlspecialchars($delivery["keresztnev"]) ?>
                            </strong>
                        </div>
                        <div class="review-info-item">
                            <span>Számlázási cím</span>
                            <strong>
                                <?= htmlspecialchars($delivery["irsz"]) ?>
                                <?= htmlspecialchars($delivery["cim"]) ?>
                            </strong>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
            <a href="index.php?page=delivery"
                class="checkout-back-button payment-back-button">
                <i class="bi bi-arrow-left"></i>
                Vissza a szállítási adatokhoz
            </a>
        </div>

        <aside class="checkout-summary checkout-summary-final">
            <h2>Rendelés összesítése</h2>
            <div class="checkout-summary-row">
                <span>Termékek összesen</span>
                <strong>
                    <?= $total ?> Ft
                </strong>
            </div>
            <div class="checkout-summary-row">
                <span>Szállítás</span>
                <strong>
                    -
                </strong>
            </div>
            <div class="checkout-summary-divider"></div>
            <div class="checkout-summary-total">
                <span>Fizetendő összeg</span>
                <strong>
                    <?= $total ?> Ft
                </strong>
            </div>
            <form
                method="post"
                action="index.php?page=payment">
                <button
                    type="submit"
                    name="submit_payment"
                    class="payment-button">
                    Rendelés leadása
                </button>
            </form>
            <p class="checkout-summary-note">
                A rendelés leadásával elfogadod a rendeléshez kapcsolódó feltételeket.
            </p>
        </aside>
    </div>
</div>