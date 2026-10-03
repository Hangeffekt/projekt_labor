<?php if(!empty($errors)):?>
    <?php foreach($errors as $error):?>
        <div class="alert alert-warning" role="alert">
            <?= $error?>
        </div>
    <?php endforeach;?>
<?php endif;?>

<?php if(isset($_GET["success"])):?>
    <div class="alert alert-success" role="alert">
        <?php if($_GET["success"] == 1):?>
            Sikeres törlés!
        <?php elseif($_GET["success"] == 2):?>
            Sikeres frissítés!
        <?php elseif($_GET["success"] == 3):?>
            Sikeres létrehozás!
        <?php elseif($_GET["success"] == 4):?>
            Sikeres hozzáadás a kosárba!
        <?php elseif($_GET["success"] == 5):?>
            A terméket frissítettük a kosárban.
        <?php elseif($_GET["success"] == 6):?>
            A terméket eltávolítottuk a kosárból.
        <?php elseif($_GET["success"] == 7):?>
            A termék nem található.
        <?php elseif($_GET["success"] == 8):?>
            A kosár üres, nem lehet továbblépni a szállításhoz.
        <?php endif;?>
    </div>
<?php endif;

if(isset($_GET["error"])):?>
    <div class="alert alert-danger" role="alert">
        <?php if($_GET["error"] == 1):?>
            Kérjük, töltse ki az összes kötelező mezőt!
        <?php elseif($_GET["error"] == 2):?>
            Érvénytelen email cím!
        <?php elseif($_GET["error"] == 3):?>
            Érvénytelen telefonszám!
        <?php elseif($_GET["error"] == 4):?>
            Érvénytelen irányítószám!
        <?php elseif($_GET["error"] == 5):?>
            Érvénytelen adószám!
        <?php elseif($_GET["error"] == 6):?>
            A termék nem található!
        <?php elseif($_GET["error"] == 8):?>
            A kosár üres, nem lehet továbblépni a szállításhoz.
        <?php elseif($_GET["error"] == 9):?>
            A szállítási adatok hiányoznak, nem lehet továbblépni a fizetéshez.
        <?php endif;?>
    </div>
<?php endif; ?>