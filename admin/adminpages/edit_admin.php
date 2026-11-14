<?php
require_once "../private/connect.php";
if (!isset($_GET['id']) || $_GET['id'] === '') {
    http_response_code(400);
    die('Hiba: az azonosító megadása kötelező.');
}

$id = preg_replace('/[^0-9]/', '', $_GET['id']);
$data = edit_admin($id);
$admin = $data['admin'] ?? [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    if($id == null || $id === '') {
        http_response_code(400);
        $errors[] = 'Hiba: az azonosító megadása kötelező.';
    }

    if (checkAdminExists($email)) {
        $errors[] = "Ez az e-mail-cím már használatban van.";
    }
    
    if($errors == null) {
        update_admin(['name' => $name, 'email' => $email], $id);
        header("Location: index.php?page=admins&success=3");
        exit();
    }
}
include("error.php");
?>

<form method="POST">
    <label for="name">Név:</label>
    <input type="text" id="name" name="name" value="<?= $admin[0]['name'] ?>" required>
    <label for="email">E-mail-cím:</label>
    <input type="email" id="email" name="email" value="<?= $admin[0]['email'] ?>" required>
    <button type="submit">Adminisztrátor adatainak frissítése</button>
</form>

