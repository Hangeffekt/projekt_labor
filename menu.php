<header class="site-header">
    <a href="index.php?page=main" class="navbar-brand site-logo">
        logo yay
    </a>
    <div class="header-main">
        <div class="header-top">
            <!--még semmi idk valami lesz-e itt-->
        </div>
        <div class="header-bottom">
            <div class="bottom-content">
                <button class="categories-button" type="button" data-bs-toggle="offcanvas" data-bs-target="#categoryMenu">
                    <span class="menu-icon">☰</span>Összes Kategória
                </button>
                <form class="search-form" action="index.php" method="get">
                    <input type="hidden" name="page" value="search">
                    <input class="search-input" type="search" name="q" placeholder="Keresés...">
                    <button class="search-button" type="submit">
                        <span class="search-icon"><i class="bi bi-search"></i></span>
                    </button>
                </form>
            </div>
            <a href="index.php?page=cart" class="cart-button">
                <span class="cart-icon"><i class="bi bi-cart"></i></span>Kosár
            </a>
        </div>
    </div>
</header>

<div class="offcanvas offcanvas-start" tabindex="-1" id="categoryMenu">
    <div class="offcanvas-header">
        logo megint yay
    </div>
    <div class="offcanvas-body">
        <?php include "category_menu.php"; ?>
    </div>
</div>