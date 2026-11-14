<?php
require_once "../private/connect.php";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $errors[] = "A jelszavak nem egyeznek.";
    }

    if (checkAdminExists($email)) {
        $errors[] = "Ez az e-mail-cím már használatban van.";
    }
    
    if($errors == null) {
        create_admin(['name' => $name, 'email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT)]);
        header("Location: index.php?page=admins&success=3");
        exit();
    }
}
include("error.php");
?>

<form method="POST">
    <label for="name">Név:</label>
    <input type="text" id="name" name="name" required>
    <label for="email">E-mail-cím:</label>
    <input type="email" id="email" name="email" required>
    <label for="password">Jelszó:</label>
    <input type="password" id="password" name="password" required>
    <label for="confirm_password">Jelszó megerősítése:</label>
    <input type="password" id="confirm_password" name="confirm_password" required>

    <button type="submit">Adminisztrátor létrehozása</button>
</form>