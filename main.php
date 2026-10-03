<?php
    $data = main_page_products();
    $products = $data["products"] ?? [];

    if (empty($products)): ?>
        nincs megjeleníthető termék
    <?php else: ?>
        <div class="product-grid">
            <?php foreach($products as $product){
                include('product_tile.php');
            } ?>
        </div>
    <?php endif; ?>
    