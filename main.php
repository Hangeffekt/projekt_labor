<?php
    $data = main_page_products();
    $products = $data["products"] ?? [];

    $category_data = load_categories(0);
    $main_categories = $category_data["categories"] ?? [];
?>

<section class="promo-carousel-section">

    <div id="promoCarousel"
         class="carousel slide"
         data-bs-ride="carousel"
         data-bs-interval="8000"
         data-bs-pause="hover">

        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="promo-slide-grid">
                    <a href="index.php?page=category&id=12"
                       class="promo-tile promo-tile-sale">
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
                            <i class="bi bi-arrow-right"></i>
                        </span>
                    </a>

                    <a href="index.php?page=category&id=13"
                       class="promo-tile promo-tile-ending">
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
                            <i class="bi bi-arrow-right"></i>
                        </span>
                    </a>
                </div>
            </div>

            <div class="carousel-item">
                <div class="promo-slide-grid">
                    <a href="index.php?page=category&id=1"
                       class="promo-tile promo-tile-featured">
                        <div class="promo-tile-content">
                            <span class="promo-tile-label">
                                A múltban ragadt?
                            </span>
                            <h2>Elektronikai termékek</h2>
                            <p>
                                Ne maradj le a legújabb elektronikai innovációkról, 
                                ezeket a termékeket neked és csak neked válogattuk!
                            </p>
                        </div>
                        <span class="promo-tile-button">
                            Elektromulok?
                            <i class="bi bi-arrow-right"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    <div class="promo-progress">
    <div class="promo-progress-bar"></div>
        <div class="carousel-indicators promo-indicators">
            <button type="button"
                    data-bs-target="#promoCarousel"
                    data-bs-slide-to="0"
                    class="active"
                    aria-current="true"
                    aria-label="Első oldal">
            </button>
            <button type="button"
                    data-bs-target="#promoCarousel"
                    data-bs-slide-to="1"
                    aria-label="Második oldal">
            </button>
        </div>
        <button class="carousel-control-prev promo-control"
                type="button"
                data-bs-target="#promoCarousel"
                data-bs-slide="prev">

            <span class="carousel-control-prev-icon"
                  aria-hidden="true"></span>

            <span class="visually-hidden">Előző</span>

        </button>
        <button class="carousel-control-next promo-control"
                type="button"
                data-bs-target="#promoCarousel"
                data-bs-slide="next">
            <span class="carousel-control-next-icon"
                  aria-hidden="true"></span>
            <span class="visually-hidden">Következő</span>
        </button>
    </div>
</div>
</section>

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

<script>
document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.querySelector('#promoCarousel');
    const progressBar = document.querySelector('.promo-progress-bar');

    if (!carousel || !progressBar) return;

    const carouselInstance = bootstrap.Carousel.getOrCreateInstance(carousel);

    function restartProgress() {
        progressBar.classList.remove('animate');
        void progressBar.offsetWidth;
        progressBar.classList.add('animate');
    }

    carousel.addEventListener('slid.bs.carousel', restartProgress);

    document.addEventListener('visibilitychange', function () {
        if (document.hidden) {
            carouselInstance.pause();
            progressBar.style.animationPlayState = 'paused';
        } else {
            restartProgress();
            progressBar.style.animationPlayState = 'running';
            carouselInstance.cycle();
        }
    });

    restartProgress();
});
</script>
