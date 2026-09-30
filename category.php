<?php
    $data = category_products($_GET['id']);
    $products = $data["products"];
?>

<?php
    if (empty($products)): ?>
        nincs megjeleníthető termék
    <?php else: 
        foreach($products as $product){
            include('product_tile.php');
        } ?>
<?php endif; ?>