<?php
require_once "../private/connect.php";
$errors = [];
$success = [];
$page = isset($_GET['page']) ? $_GET['page'] : 'kezdolap';

$page = preg_replace('/[^a-zA-Z0-9-_]/', '', $page);

$file = load_page_file($page);
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">
        <?php if (file_exists($file)) { ?>
            <?php require_once("menu.php");
            include $file; ?>
            
        <?php } else {
            echo "<h2>404 - Az oldal nem található</h2>";
        } ?>
    </div>

</body>
</html>
