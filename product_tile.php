<div class="card" style="width: 18rem;">
    <img src="<?= $product['image'] ?>" class="card-img-top" alt="<?= $product['product_name'] ?>">
    <div class="card-body">
        <h5 class="card-title"><?= $product['product_name'] ?></h5>
        <p class="card-text"><?= $product['sale_price'] ?></p>
        <a href="index.php?page=product&id=<?= $product['id'] ?>" class="btn btn-primary">Részletek</a>
        <form method="post">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <button type="submit" class="btn btn-success" name="add_to_cart">Kosárba</button>
        </form>
    </div>
</div>
