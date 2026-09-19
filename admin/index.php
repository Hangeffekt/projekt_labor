<?php
require_once "../private/connect.php";
$errors = [];
$success = [];
$page = isset($_GET['page']) ? $_GET['page'] : 'kezdolap';

$page = preg_replace('/[^a-zA-Z0-9-_]/', '', $page);

$file = load_page_file($page);
?>

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
        <?php endif;?>
    </div>
<?php endif;?>

<?php
    if (file_exists($file)) {
        include $file;
    } else {
        echo "<h2>404 - Az oldal nem található</h2>";
    }
?>