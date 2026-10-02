<?php
require_once "../private/connect.php";
session_start();
$errors = [];
$success = [];

if(!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] === null) {
    $page = "login";
}
else {
    $page = isset($_GET['page']) ? $_GET['page'] : 'main';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

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
        <?php if(file_exists($file)) { 
            if(isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] != null) {
                require_once("menu.php");
            }
            include $file; ?>
            
        <?php } else {
            echo "<h2>404 - Az oldal nem található</h2>";
        } ?>
    </div>

</body>
</html>
