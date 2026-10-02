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
        $errors[] = "Ez az email már létezik.";
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
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <label for="confirm_password">Confirm Password:</label>
    <input type="password" id="confirm_password" name="confirm_password" required>

    <button type="submit">Create Admin</button>
</form>