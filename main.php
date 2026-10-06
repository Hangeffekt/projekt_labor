<?php
    $data = main_page_products();
    $products = $data["products"] ?? [];

    $category_data = load_categories(0);
    $main_categories = $category_data["categories"] ?? [];
?>

<div class="promo-tiles">
    <a href="index.php?page=category&id=12" class="promo-tile promo-tile-sale">
        <div class="promo-tile-content">
            <span class="promo-tile-label">
                Kiemelt ajánlat
            </span>
            <h2>Akciós termékek</h2>
            <p>
                Nézd meg akciós termékeinket, és találd meg
                a legjobb ajánlatokat kedvező áron.
            </p>
        </div>
        <span class="promo-tile-button">
            Megnézem
        </span>
    </a>


    <a href="index.php?page=category&id=13" class="promo-tile promo-tile-ending">
        <div class="promo-tile-content">
            <span class="promo-tile-label">
                Utolsó darabok
            </span>
            <h2>Kifutó termékek</h2>
            <p>
                Kifutó termékek kedvező áron
                a készlet erejéig.
            </p>
        </div>
        <span class="promo-tile-button">
            Mutasd
        </span>
    </a>
</div>

<?php if (!empty($main_categories)): ?>

<section class="main-category-section">
    <div class="main-category-heading">
        <h2>Kategóriák</h2>
        <div class="main-category-controls">
            <button
                type="button"
                class="main-category-arrow"
                id="categoryScrollLeft">
                <i class="bi bi-chevron-left"></i>
            </button>
            <button
                type="button"
                class="main-category-arrow"
                id="categoryScrollRight">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </div>

    <div class="main-category-wrapper">
        <div class="main-category-list" id="mainCategoryList">
            <?php foreach ($main_categories as $category): ?>
                <a
                    href="index.php?page=category&id=<?= $category['id'] ?>"
                    class="main-category-tile">
                    <span class="main-category-name">
                        <?= htmlspecialchars($category['name']) ?>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (empty($products)): ?>
    <div class="no-products">
        nincs megjeleníthető termék
    </div>

<?php else: ?>
    <section class="main-products-section">
        <div class="main-products-heading">
            <h2>Nagyszerű ajánlataink</h2>
        </div>
        <div class="product-grid">
            <?php foreach ($products as $product): ?>
                <?php include('product_tile.php'); ?>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const list = document.getElementById("mainCategoryList");
    const left = document.getElementById("categoryScrollLeft");
    const right = document.getElementById("categoryScrollRight");

    if (!list || !left || !right) {
        return;
    }

    left.addEventListener("click", function () {
        list.scrollBy({
            left: -400,
            behavior: "smooth"
        });
    });

    right.addEventListener("click", function () {
        list.scrollBy({
            left: 400,
            behavior: "smooth"
        });
    });

});
</script>