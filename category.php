<?php
if (!isset($_GET['id'])) {
        echo "<h2>404 - Az oldal nem található</h2>";
        exit;
    }
    $id = preg_replace('/[^0-9]/', '', $_GET['id']);
    $data = category_products($id);
    $products = $data["products"];
?>

<?php include('error.php'); ?>

<?php
    include "breadcrumb.php";
    if (empty($products)): ?>
        nincs megjeleníthető termék
    <?php else: ?>
        <div class="product-grid">
            <?php foreach($products as $product){
                include('product_tile.php');
            } ?>
        </div>
<?php endif; ?>