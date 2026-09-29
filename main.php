<?php
    $data = main_page_products();
    $products = $data["products"] ?? [];

    if (empty($products)): ?>
        nincs megjeleníthető termék
    <?php else: 
        foreach($products as $product){
            include('product_tile.php');
        } ?>
    <?php endif; ?>
    