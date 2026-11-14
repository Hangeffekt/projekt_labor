<?php
$errors = [];

if (!isset($_GET['id']) || $_GET['id'] === '') {
    http_response_code(400);
    die('Hiba: az azonosító megadása kötelező.');
}

$data = edit_delivery($_GET['id']);
$delivery = $data['delivery'] ?? [];
$products_list =  $data['prodcuts_list'] ?? [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(isset($_POST["modify"])){
        $product_id = $_POST['product_id'] ?? '';
        $net_price = $_POST['net_price'] ?? '';
        $sale_price = $_POST['sale_price'] ?? '';
        $qty = $_POST['qty'] ?? '';
        $product_data = search_in_transaction($product_id, $delivery["id"]);

        if(count($product_data) == 1){
            $update_data["net_price"] = $net_price;
            $update_data["sale_price"] = $sale_price;
            $update_data["qty"] = $qty;
            modify_product_on_delivery_list($update_data, $product_id);
            header("location:index.php?page=delivery_storno&id=".$delivery["id"]."&success=2");
        }
        else{
            header("location:index.php?page=delivery_storno&id=".$delivery["id"]."&error=2");
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_GET["delete_product"])){
        $product_id = $_GET['delete_product'] ?? '';
        $product_data = search_in_transaction($product_id, $delivery["id"]);
        var_dump($product_id);
        if(count($product_data) == 1){
            delete_product_on_delivery_list($product_id);
            header("location:index.php?page=delivery_storno&id=".$delivery["id"]."&success=1");
        }
        else{
            header("location:index.php?page=delivery_storno&id=".$delivery["id"]."&error=2");
        }
    }
}
?>
<?php include("error.php"); ?>

<?php if($products_list):?>
    <form method="post">
        <?php foreach($products_list as $product): ?>
            <?= $product['brand_name'] ?> <?= $product['product_name'] ?><br>
            <?php if($product['status'] == 'COMPLETED'): ?>
                    Nettó ár
                    <input type="number" value="<?= $product['net_price'] ?>" name="<?= $product['id'] ?>_net_price" required>
                    Eladási ár
                    <input type="number" value="<?= $product['sale_price'] ?>" name="<?= $product['id'] ?>_sale_price" required>
                    Mennyiség
                    <input type="number" value="<?= $product['qty'] ?>" name="<?= $product['id'] ?>_qty" required>
            <?php endif; ?>
        <?php endforeach; ?>
    <input type="submit" name="modify" value="Módosít">
    </form>
<?php else: ?>
    <p>Nem található termék.</p>
<?php endif; ?>