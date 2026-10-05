<?php
    $category_id = $_GET['id'] ?? 0;

    $category_data = category_products($category_id);
    $products = $category_data["products"] ?? [];

    $current_category = get_category($category_id);

    $subcategory_data = load_categories($category_id);
    $subcategories = $subcategory_data["categories"] ?? [];
?>

<?php include("breadcrumb.php"); ?>


<div class="category-products-layout <?= empty($subcategories) ? 'no-subcategories' : '' ?>">
    <?php if (!empty($subcategories)): ?>
        <aside class="category-subcategories">
            <div class="category-subcategories-title">
                <?= htmlspecialchars($current_category['name']) ?>
            </div>
            <ul>
                <?php foreach ($subcategories as $subcategory): ?>
                    <li>
                        <a href="index.php?page=category&id=<?= $subcategory['id'] ?>">
                            <?= htmlspecialchars($subcategory['name']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </aside>
    <?php endif; ?>

    <div class="category-products">
        <div class="category-products-heading">
            <h1><?= htmlspecialchars($current_category['name']) ?></h1>
        </div>
        <?php if (empty($products)): ?>
            <div class="no-products">
                nincs megjeleníthető termék
            </div>
        <?php else: ?>
            <div class="product-grid">
                <?php foreach ($products as $product): ?>
                    <?php include("product_tile.php"); ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>