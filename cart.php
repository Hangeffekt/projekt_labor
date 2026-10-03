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

<?php if(!empty($carts)): ?>
    <?php foreach($carts as $cart): 
        $product = product_details($cart["id"]);
        $product = $product["product"];
        $total += $product["sale_price"] * $cart["quantity"];
        ?>
        <div>
            <h3><?= $product["brand_name"]; ?> <?= $product["product_name"]; ?></h3>
            <p>Ár: <?= $product["sale_price"]; ?> Ft</p>
            <p>Mennyiség: <?= $cart["quantity"]; ?> db</p>
            <form method="post">
                <input type="hidden" name="cart_id" value="<?= $cart["id"]; ?>">
                <input type="number" name="quantity" value="<?= $cart["quantity"]; ?>" min="1">
                <button type="submit" name="update_cart">Update</button>
            </form>
            <form method="post">
                <input type="hidden" name="cart_id" value="<?= $cart["id"]; ?>">
                <button type="submit" name="remove_from_cart">Remove</button>
            </form>
        </div>


        
    <?php endforeach; ?>
    <p><strong>Összeg: <?= $total; ?> Ft</strong></p>
    <a href="index.php?page=delivery">Tovább a szállításhoz</a>
<?php else: ?>
    <p>Your cart is empty.</p>
<?php endif; ?>