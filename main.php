<?php
    $data = main_page_products();
    $products = $data["products"] ?? [];

    if (empty($products)): ?>
        nincs megjeleníthető termék
    <?php else: 
        foreach($products as $product): ?>
        
            <div class="card" style="width: 18rem;">
                <img src="<?= $product['image'] ?>" class="card-img-top" alt="<?= $product['product_name'] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $product['product_name'] ?></h5>
                    <p class="card-text"><?= $product['sale_price'] ?></p>
                    <a href="#" class="btn btn-primary">Részletek</a>
                    <form action="index.php?page=cart" method="post">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <button type="submit" class="btn btn-success">Kosárba</button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    