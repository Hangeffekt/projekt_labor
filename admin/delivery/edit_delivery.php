<?php
$errors = [];

if (!isset($_GET['id']) || $_GET['id'] === '') {
    http_response_code(400);
    die('Hiba: a id query paraméter kötelező.');
}

$data = edit_delivery($_GET['id']);
$delivery = $data['delivery'] ?? [];
$products_list =  $data['prodcuts_list'] ?? [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST["eanbtn"])){
        $ean = $_POST['ean'] ?? '';
        $product_data = search_by_ean($ean);
        
        if(count($product_data) == 1){
            $search_data["product_id"] = $product_data[0]["id"];
            $search_data["inner_table_id"] = $delivery["id"];
            add_to_deliverylist($search_data);
        }
        else
            $errors[] = "Nem található termék az vonalkódhoz!";
    }

    if(isset($_POST["modify"])){
        $product_id = $_POST['product_id'] ?? '';
        $net_price = $_POST['net_price'] ?? '';
        $sale_price = $_POST['sale_price'] ?? '';
        $qty = $_POST['qty'] ?? '';
    }
}
?>
<?php include("error.php"); ?>
<form method="post">
    <label for="ean">Ean:</label>
    <input type="number" name="ean">
    <input type="submit" name="eanbtn" value="Keresés">
</form>

<form method="post">
    <label for="ean">Márka:</label>
    <label for="ean">Név:</label>
    <label for="ean">Ár:</label>
    <input type="submit" name="searchbtn" value="Keresés">
</form>

<?php if($products_list):?>
    <?php foreach($products_list as $product): ?>
            <?= $product['brand_name'] ?> <?= $product['product_name'] ?>
            <form method="post">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                net price
                <input type="number" value="<?= $product['net_price'] ?>" name="net_price" required>
                sale price
                <input type="number" value="<?= $product['sale_price'] ?>" name="sale_price" required>
                qty
                <input type="number" value="<?= $product['qty'] ?>" name="qty" required>
                <input type="submit" name="modify" value="Módosít">
                <a href="index.php?page=edit_delivery&id=<?= $delivery['id'] ?>delete_product=<?= $product['id'] ?>">Törlés</a>
            </form>
    <?php endforeach; ?>
<?php else: ?>
    <p>No products found.</p>
<?php endif; ?>