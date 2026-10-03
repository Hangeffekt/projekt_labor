<?php
session_start();
require_once "private/shop_connect.php";
$errors = [];
$success = [];
$page = isset($_GET['page']) ? $_GET['page'] : 'main';

$page = preg_replace('/[^a-zA-Z0-9-_]/', '', $page);

$file = load_page_file($page);

if ($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = 1;

    $data = $_SESSION["cart_data"] ?? [];
    $carts = $data["cart"] ?? [];

    $found = false;
    foreach ($carts as &$cart) {
        if ($cart["id"] == $product_id) {
            $cart["quantity"] += $quantity;
            $found = true;
            break;
        }
    }
    unset($cart);
    
    if (!$found) {
        $product_data = product_details($product_id);
        var_dump($product_data);
        if (!empty($product_data["product"])) {
            $product = $product_data["product"];
            $carts[] = [
                "id" => $product["id"],
                "price" => $product["sale_price"],
                "quantity" => $quantity
            ];
        } else {
            header("Location: " . $_SERVER['REQUEST_URI'] . "&error=7");
        }
    }

    $_SESSION["cart_data"]["cart"] = $carts;

    header("Location: " . $_SERVER['REQUEST_URI'] . "&success=4");
    exit;
    
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<?php
    if (file_exists($file)) { ?>
        <?php require_once("menu.php");

        include $file; ?>
        
    <?php } else {
        echo "<h2>404 - Az oldal nem található</h2>";
    }
?>