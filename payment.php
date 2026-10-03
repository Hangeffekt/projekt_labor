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
        // Payment processing logic here
        // For example, you can integrate with a payment gateway API

        // After successful payment, clear the cart and delivery data
        save_cart_data($_SESSION["cart_data"]);
        save_delivery_data($_SESSION["delivery_data"]);
        unset($_SESSION["cart_data"]);
        unset($_SESSION["delivery_data"]);

        // Redirect to a success page or order confirmation page
        header("Location: index.php?page=success");
        exit;
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

    <h5>Szállítási adatok</h5>
    <p>Név: <?= $delivery["vezeteknev"] ?> <?= $delivery["keresztnev"] ?></p>
    <p>Email: <?= $delivery["email"] ?></p>
    <p>Telefonszám: <?= $delivery["telefonszam"] ?></p>
    <p>Cím: <?= $delivery["irsz"] ?> <?= $delivery["cim"] ?></p>
    <h5>Számlázási adatok</h5>
    <?php if($delivery["invoice"]): ?>
        <p>Név: <?= $delivery["name"] ?></p>
        <p>Adószám: <?= $delivery["tax_number"] ?></p>
        <p>Cím: <?= $delivery["invoice_irsz"] ?> <?= $delivery["invoice_cim"] ?></p>
    <?php else: ?>
        <p>Név: <?= $delivery["vezeteknev"] ?> <?= $delivery["keresztnev"] ?></p>
        <p>Cím: <?= $delivery["irsz"] ?> <?= $delivery["cim"] ?></p>
    <?php endif; ?>
    <form method="post" action="index.php?page=payment">
        <button type="submit" name="submit_payment">Fizetés</button>
    </form>
    <a href="index.php?page=delivery">Vissza</a>