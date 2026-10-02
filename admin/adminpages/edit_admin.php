<?php
require_once "../private/connect.php";
if (!isset($_GET['id']) || $_GET['id'] === '') {
    http_response_code(400);
    die('Hiba: a id query paraméter kötelező.');
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
        $errors[] = 'Hiba: a id query paraméter kötelező.';
    }

    if (checkAdminExists($email)) {
        $errors[] = "Ez az email már létezik.";
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
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?= $admin[0]['name'] ?>" required>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?= $admin[0]['email'] ?>" required>
    <button type="submit">Update Admin</button>
</form>

