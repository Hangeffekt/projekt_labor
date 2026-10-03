<?php
    $data = $_SESSION["cart_data"] ?? [];
    $carts = $data["cart"];
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

    <?php foreach($carts as $cart): 
        $product = product_details($cart["id"]);
        $product = $product["product"];
        $total += $product["sale_price"] * $cart["quantity"];
        ?>
        <div>
            <h3><?= $product["brand_name"]; ?> <?= $product["product_name"]; ?></h3>
            <p>Ár: <?= $product["sale_price"]; ?> Ft</p>
            <p>Mennyiség: <?= $cart["quantity"]; ?> db</p>
            <p>Összeg: <?= $product["sale_price"] * $cart["quantity"]; ?> Ft</p>
        </div>
    <?php endforeach; ?>
    <p><strong>Összeg: <?= $total; ?> Ft</strong></p>

<form method="post">
    <div>
        <h3>Szállítási adatok</h3>
        <label for="vezeteknev">Vezetéknév:</label>
        <input type="text" id="vezeteknev" name="vezeteknev" value="<?= $_SESSION['delivery_data']['vezeteknev'] ?? '' ?>" required>
        <label for="keresztnev">Keresztnév:</label>
        <input type="text" id="keresztnev" name="keresztnev" value="<?= $_SESSION['delivery_data']['keresztnev'] ?? '' ?>" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= $_SESSION['delivery_data']['email'] ?? '' ?>" required>
        <label for="telefonszam">Telefonszám:</label>
        <input type="tel" id="telefonszam" name="telefonszam" value="<?= $_SESSION['delivery_data']['telefonszam'] ?? '' ?>" required>
        <label for="irsz">Irányítószám:</label>
        <input type="number" id="irsz" name="irsz" value="<?= $_SESSION['delivery_data']['irsz'] ?? '' ?>" required>
        <label for="cim">Cím:</label>
        <input type="text" id="cim" name="cim" value="<?= $_SESSION['delivery_data']['cim'] ?? '' ?>" required>
    </div>
    <hr>
    <input type="checkbox" id="invoice" name="invoice" value="1">
    <label for="invoice">Számlázási cím megegyezik a szállítási címmel</label>
    <div id="invoice_fields" style="display: none;">
        <h5>Számlázási adatok</h5>
        <label for="name">Név:</label>
        <input type="text" id="name" name="name" value="<?= $_SESSION['delivery_data']['name'] ?? '' ?>">
        <label for="tax_number">Adószám:</label>
        <input type="text" id="tax_number" name="tax_number" value="<?= $_SESSION['delivery_data']['tax_number'] ?? '' ?>">
        <label for="invoice_irsz">Irányítószám:</label>
        <input type="number" id="invoice_irsz" name="invoice_irsz" value="<?= $_SESSION['delivery_data']['invoice_irsz'] ?? '' ?>">
        <label for="invoice_cim">Cím:</label>
        <input type="text" id="invoice_cim" name="invoice_cim" value="<?= $_SESSION['delivery_data']['invoice_cim'] ?? '' ?>">
    </div>
    <button type="submit" name="submit_delivery">Tovább a fizetéshez</button>
</form>
<a href="index.php?page=cart">Vissza</a>