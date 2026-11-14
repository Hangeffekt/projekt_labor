<?php if(isset($_GET["success"])):?>
    <div class="alert alert-success" role="alert">
        <?php if($_GET["success"] == 1):?>
            Sikeres törlés!
        <?php elseif($_GET["success"] == 2):?>
            Sikeres frissítés!
        <?php elseif($_GET["success"] == 3):?>
            Sikeres létrehozás!
        <?php elseif($_GET["success"] == 4):?>
            Sikeres lezárás!
        <?php endif;?>
    </div>
<?php endif;?>

<?php if(isset($_GET["error"])):?>
    <div class="alert alert-success" role="alert">
        <?php if($_GET["error"] == 1):?>
            Nem található termék ehhez a vonalkódhoz!
        <?php elseif($_GET["error"] == 2):?>
            Nem található termék!
        <?php endif;?>
    </div>
<?php else:?>
    <?php if(!empty($errors)):?>
        <?php foreach($errors as $error):?>
            <div class="alert alert-warning" role="alert">
                <?= $error?>
            </div>
        <?php endforeach;?>
    <?php endif;?>
<?php endif;?>
