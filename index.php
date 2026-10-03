<?php
require_once "private/shop_connect.php";
$errors = [];
$success = [];
$page = isset($_GET['page']) ? $_GET['page'] : 'main';

$page = preg_replace('/[^a-zA-Z0-9-_]/', '', $page);

$file = load_page_file($page);
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<div class="header-head"></div>
<div class="container">
    <?php
        if (file_exists($file)) { ?>
            <?php require_once("menu.php");
            include $file; ?>
        
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
        
        <?php } else {
            echo "<h2>404 - Az oldal nem található</h2>";
        }
    ?>
</div>