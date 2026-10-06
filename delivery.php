<?php
    $data = $_SESSION["cart_data"] ?? [];
    $carts = $data["cart"] ?? [];
    $total = 0;

    if (empty($carts)) {
        header("Location: index.php?page=cart&error=8");
        exit;
    }


    if (isset($_POST['submit_delivery'])) {

        $vezeteknev = trim($_POST['vezeteknev'] ?? '');
        $keresztnev = trim($_POST['keresztnev'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telefonszam = trim($_POST['telefonszam'] ?? '');
        $irsz = trim($_POST['irsz'] ?? '');
        $cim = trim($_POST['cim'] ?? '');

        $invoice = isset($_POST['invoice']) ? 1 : 0;

        $name = trim($_POST['name'] ?? '');
        $tax_number = trim($_POST['tax_number'] ?? '');
        $invoice_irsz = trim($_POST['invoice_irsz'] ?? '');
        $invoice_cim = trim($_POST['invoice_cim'] ?? '');


        if (
            $vezeteknev != '' &&
            $keresztnev != '' &&
            $email != '' &&
            $telefonszam != '' &&
            $irsz != '' &&
            $cim != '' &&
            (
                !$invoice ||
                (
                    $name != '' &&
                    $invoice_irsz != '' &&
                    $invoice_cim != ''
                )
            )
        ) {

            $_SESSION['delivery_data'] = [
                'vezeteknev' => $vezeteknev,
                'keresztnev' => $keresztnev,
                'email' => $email,
                'telefonszam' => $telefonszam,
                'irsz' => $irsz,
                'cim' => $cim,
                'invoice' => $invoice,
                'name' => $name,
                'tax_number' => $tax_number,
                'invoice_irsz' => $invoice_irsz,
                'invoice_cim' => $invoice_cim
            ];

            header("Location: index.php?page=payment");
            exit;

        } else {

            header("Location: index.php?page=delivery&error=1");
            exit;
        }
    }
?>


<div class="checkout-page">
    <div class="checkout-header">
        <h1>Szállítási adatok</h1>
        <div class="checkout-steps">
            <div class="checkout-step active">
                <span>1</span>
                <strong>Szállítás</strong>
            </div>
            <div class="checkout-step-line"></div>
            <div class="checkout-step">
                <span>2</span>
                <strong>Összesítés</strong>
            </div>
        </div>
    </div>


    <div class="checkout-layout">
        <div class="checkout-main">
            <form
                method="post"
                class="checkout-form"
                id="delivery_form">
                <section class="checkout-section">
                    <div class="checkout-section-header">
                        <div class="checkout-section-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        <div>
                            <h2>Személyes adatok</h2>
                        </div>
                    </div>
                    <div class="checkout-form-grid">
                        <div class="checkout-form-group">
                            <label for="vezeteknev">
                                Vezetéknév
                            </label>
                            <input
                                type="text"
                                id="vezeteknev"
                                name="vezeteknev"
                                value="<?= htmlspecialchars($_SESSION['delivery_data']['vezeteknev'] ?? '') ?>"
                                required>
                        </div>
                        <div class="checkout-form-group">
                            <label for="keresztnev">
                                Keresztnév
                            </label>
                            <input
                                type="text"
                                id="keresztnev"
                                name="keresztnev"
                                value="<?= htmlspecialchars($_SESSION['delivery_data']['keresztnev'] ?? '') ?>"
                                required>
                        </div>
                        <div class="checkout-form-group">
                            <label for="email">
                                Email cím
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="<?= htmlspecialchars($_SESSION['delivery_data']['email'] ?? '') ?>"
                                required>
                        </div>
                        <div class="checkout-form-group">
                            <label for="telefonszam">
                                Telefonszám
                            </label>
                            <input
                                type="tel"
                                id="telefonszam"
                                name="telefonszam"
                                value="<?= htmlspecialchars($_SESSION['delivery_data']['telefonszam'] ?? '') ?>"
                                required>
                        </div>
                    </div>
                </section>

                <section class="checkout-section">
                    <div class="checkout-section-header">
                        <div class="checkout-section-icon">
                            <i class="bi bi-truck"></i>
                        </div>
                        <div>
                            <h2>Szállítási cím</h2>
                        </div>
                    </div>
                    <div class="checkout-form-grid">
                        <div class="checkout-form-group checkout-form-group-small">
                            <label for="irsz">
                                Irányítószám
                            </label>
                            <input
                                type="text"
                                id="irsz"
                                name="irsz"
                                value="<?= htmlspecialchars($_SESSION['delivery_data']['irsz'] ?? '') ?>"
                                required>
                        </div>
                        <div class="checkout-form-group checkout-form-group-large">
                            <label for="cim">
                                Cím
                            </label>
                            <input
                                type="text"
                                id="cim"
                                name="cim"
                                value="<?= htmlspecialchars($_SESSION['delivery_data']['cim'] ?? '') ?>"
                                placeholder="Utca, házszám, emelet, ajtó..."
                                required>
                        </div>
                    </div>
                </section>

                <section class="checkout-section">
                    <div class="invoice-checkbox">
                        <input
                            type="checkbox"
                            id="invoice"
                            name="invoice"
                            value="1"
                            <?= !empty($_SESSION['delivery_data']['invoice']) ? 'checked' : '' ?>>
                        <label for="invoice">
                            <span class="invoice-checkbox-title">
                                A szállítási cím nem egyezik meg a számlázási adatokkal.
                            </span>
                        </label>
                    </div>
                    <div
                        id="invoice_fields"
                        class="invoice-fields"
                        style="display: <?= !empty($_SESSION['delivery_data']['invoice']) ? 'block' : 'none' ?>;">
                        <div class="checkout-section-header invoice-header">
                            <div class="checkout-section-icon">
                                <i class="bi bi-receipt"></i>
                            </div>
                            <div>
                                <h2>Számlázási adatok</h2>
                            </div>
                        </div>
                        <div class="checkout-form-grid">
                            <div class="checkout-form-group">
                                <label for="name">
                                    Név
                                </label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="<?= htmlspecialchars($_SESSION['delivery_data']['name'] ?? '') ?>">
                            </div>
                            <div class="checkout-form-group">
                                <label for="tax_number">
                                    Adószám
                                </label>
                                <input
                                    type="text"
                                    id="tax_number"
                                    name="tax_number"
                                    value="<?= htmlspecialchars($_SESSION['delivery_data']['tax_number'] ?? '') ?>">
                            </div>
                            <div class="checkout-form-group checkout-form-group-small">
                                <label for="invoice_irsz">
                                    Irányítószám
                                </label>
                                <input
                                    type="text"
                                    id="invoice_irsz"
                                    name="invoice_irsz"
                                    value="<?= htmlspecialchars($_SESSION['delivery_data']['invoice_irsz'] ?? '') ?>">
                            </div>
                            <div class="checkout-form-group checkout-form-group-large">
                                <label for="invoice_cim">
                                    Cím
                                </label>
                                <input
                                    type="text"
                                    id="invoice_cim"
                                    name="invoice_cim"
                                    value="<?= htmlspecialchars($_SESSION['delivery_data']['invoice_cim'] ?? '') ?>">
                            </div>
                        </div>
                    </div>
                </section>

                <div class="checkout-buttons">
                    <a
                        href="index.php?page=cart"
                        class="checkout-back-button">
                        <i class="bi bi-arrow-left"></i>
                        Vissza a kosárhoz
                    </a>
                    <button
                        type="submit"
                        name="submit_delivery"
                        class="checkout-next-button">
                        Tovább az összesítéshez
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>

        <aside class="checkout-summary">
            <h2>Rendelés</h2>
            <?php foreach ($carts as $cart):
                $product_data = product_details($cart["id"]);
                $product = $product_data["product"] ?? [];
                if (empty($product)) {
                    continue;
                }
                $item_total = $product["sale_price"] * $cart["quantity"];
                $total += $item_total;
            ?>
                <div class="checkout-summary-product">
                    <div class="checkout-summary-image">
                        <img
                            src="<?= htmlspecialchars($product["image"]) ?>"
                            alt="<?= htmlspecialchars($product["product_name"]) ?>">
                    </div>
                    <div class="checkout-summary-product-info">
                        <strong>
                            <?= htmlspecialchars($product["product_name"]) ?>
                        </strong>
                        <span>
                            <?= $cart["quantity"] ?> db
                        </span>
                    </div>
                    <strong class="checkout-summary-product-price">
                        <?= $item_total ?> Ft
                    </strong>
                </div>
            <?php endforeach; ?>
            <div class="checkout-summary-divider"></div>
            <div class="checkout-summary-total">
                <span>Végösszeg</span>
                <strong>
                    <?= $total ?> Ft
                </strong>
            </div>
        </aside>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const invoice = document.getElementById("invoice");
    const invoiceFields = document.getElementById("invoice_fields");

    if (!invoice || !invoiceFields) {
        return;
    }

    invoice.addEventListener("change", function () {
        invoiceFields.style.display = this.checked ? "block" : "none";
    });

});
</script>