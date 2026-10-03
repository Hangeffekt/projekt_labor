<?php
    $data = $_SESSION["cart_data"] ?? [];
    $carts = $data["cart"] ?? [];
    $total = 0;

    if (empty($carts)) {
        header("Location: index.php?page=cart&error=8");
        exit;
    }

    if(isset($_POST['submit_delivery'])) {
        $vezeteknev = $_POST['vezeteknev'];
        $keresztnev = $_POST['keresztnev'];
        $email = $_POST['email'];
        $telefonszam = $_POST['telefonszam'];
        $irsz = $_POST['irsz'];
        $cim = $_POST['cim'];

        $invoice = isset($_POST['invoice']) ? 1 : 0;
        $name = $_POST['name'] ?? '';
        $tax_number = $_POST['tax_number'] ?? '';
        $invoice_irsz = $_POST['invoice_irsz'] ?? '';
        $invoice_cim = $_POST['invoice_cim'] ?? '';

        if($vezeteknev != '' && $keresztnev != '' && $email != '' && $telefonszam != '' && $irsz != '' && $cim != '' && (!$invoice || ($name != '' && $invoice_irsz != '' && $invoice_cim != ''))) {
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

<div class="delivery-page">
    <h2 class="page-title">Szállítási adatok</h2>
    <div class="delivery-layout">
        <div class="delivery-main">
            <div class="delivery-section">
                <h3>Termékek</h3>
                <?php foreach($carts as $cart): 
                    $product = product_details($cart["id"]);
                    $product = $product["product"];
                    $total += $product["sale_price"] * $cart["quantity"];
                    ?>
                    <div class="delivery-product">
                        <div class="delivery-product-info">
                            <h4><?= $product["brand_name"]; ?> <?= $product["product_name"]; ?></h4>
                            <p>Ár: <?= $product["sale_price"]; ?> Ft</p>
                            <p>Mennyiség: <?= $cart["quantity"]; ?> db</p>
                            <p>Összeg: <?= $product["sale_price"] * $cart["quantity"]; ?> Ft</p>
                        </div>
                    </div>
                <?php endforeach; ?>
                <p class="delivery-total"><strong>Összeg: <?= $total; ?> Ft</strong></p>
            </div>
            <form method="post" class="delivery-form" id="delivery_form">
                <div class="delivery-section">
                    <h3>Szállítási adatok</h3>
                    <div class="delivery-form-grid">
                        <div class="delivery-form-group">
                            <label for="vezeteknev">Vezetéknév:</label>
                            <input type="text" id="vezeteknev" name="vezeteknev" value="<?= htmlspecialchars($_SESSION['delivery_data']['vezeteknev'] ?? '') ?>" required>
                        </div>
                        <div class="delivery-form-group">
                            <label for="keresztnev">Keresztnév:</label>
                            <input type="text" id="keresztnev" name="keresztnev" value="<?= htmlspecialchars($_SESSION['delivery_data']['keresztnev'] ?? '') ?>" required>
                        </div>
                        <div class="delivery-form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="<?= htmlspecialchars($_SESSION['delivery_data']['email'] ?? '') ?>" required>
                        </div>
                        <div class="delivery-form-group">
                            <label for="telefonszam">Telefonszám:</label>
                            <input type="tel" id="telefonszam" name="telefonszam" value="<?= htmlspecialchars($_SESSION['delivery_data']['telefonszam'] ?? '') ?>" required>
                        </div>
                        <div class="delivery-form-group">
                            <label for="irsz">Irányítószám:</label>
                            <input type="number" id="irsz" name="irsz" value="<?= htmlspecialchars($_SESSION['delivery_data']['irsz'] ?? '') ?>" required>
                        </div>
                        <div class="delivery-form-group">
                            <label for="cim">Cím:</label>
                            <input type="text" id="cim" name="cim" value="<?= htmlspecialchars($_SESSION['delivery_data']['cim'] ?? '') ?>" required>
                        </div>
                    </div>
                </div>

                <div class="delivery-section">
                    <div class="invoice-checkbox">
                        <input type="checkbox" id="invoice" name="invoice" value="1"
                            <?= !empty($_SESSION['delivery_data']['invoice']) ? 'checked' : '' ?>>
                        <label for="invoice">Számlázási cím megegyezik a szállítási címmel</label>
                    </div>
                    <div id="invoice_fields" class="invoice-fields"
                        style="display: <?= !empty($_SESSION['delivery_data']['invoice']) ? 'block' : 'none' ?>;">
                        <h5>Számlázási adatok</h5>
                        <div class="delivery-form-grid">
                            <div class="delivery-form-group">
                                <label for="name">Név:</label>
                                <input type="text" id="name" name="name" value="<?= htmlspecialchars($_SESSION['delivery_data']['name'] ?? '') ?>">
                            </div>
                            <div class="delivery-form-group">
                                <label for="tax_number">Adószám:</label>
                                <input type="text" id="tax_number" name="tax_number" value="<?= htmlspecialchars($_SESSION['delivery_data']['tax_number'] ?? '') ?>">
                            </div>
                            <div class="delivery-form-group">
                                <label for="invoice_irsz">Irányítószám:</label>
                                <input type="number" id="invoice_irsz" name="invoice_irsz" value="<?= htmlspecialchars($_SESSION['delivery_data']['invoice_irsz'] ?? '') ?>">
                            </div>
                            <div class="delivery-form-group">
                                <label for="invoice_cim">Cím:</label>
                                <input type="text" id="invoice_cim" name="invoice_cim" value="<?= htmlspecialchars($_SESSION['delivery_data']['invoice_cim'] ?? '') ?>">
                            </div>
                        </div>
                    </div>
                </div>

                </form>

                <div class="delivery-buttons">
                    <a href="index.php?page=cart" class="back-button">Vissza</a>

                    <button type="submit" name="submit_delivery" form="delivery_form" class="delivery-button">
                        Tovább a fizetéshez
                    </button>
                </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('invoice').addEventListener('change', function() {
        document.getElementById('invoice_fields').style.display = this.checked ? 'block' : 'none';
    });
</script>