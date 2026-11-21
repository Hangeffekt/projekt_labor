
<header class="site-header">
    <a href="index.php?page=main" class="navbar-brand site-logo">
        <span class="theme-logo" role="img" aria-label="Webshop logo"></span>
        <span class="site-logo-tagline">ELADUNK DOLGOKAT HA MEGVESZIK</span>
    </a>

    <div class="header-main">
        <div class="header-top">
            <div class="header-actions">
                <button class="settings-button"
                        type="button"
                        data-bs-toggle="modal"
                        data-bs-target="#settingsModal"
                        aria-label="Beállítások">
                    <i class="bi bi-gear"></i>
                </button>
                <button class="profile-button"
                        type="button"
                        aria-label="Profil">
                    <i class="bi bi-person-circle"></i>
                </button>
            </div>
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
        <img src="assets/logo.png" alt="Webshop logo" class="offcanvas-logo">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Bezárás"></button>
    </div>

    <div class="offcanvas-body">
        <?php include "category_menu.php"; ?>
    </div>
</div>

<?php include "settings.php"; ?>
