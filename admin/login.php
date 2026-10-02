<?php
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $errors[] = "Kérlek töltsd ki az összes mezőt.";
    } else {
        $admin = getAdminByEmail($email);
        if ($admin && password_verify($password, $admin['password'])) {
            session_start();
            $_SESSION['is_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            header("Location: index.php?page=main");
            exit();
        } else {
            $errors[] = "Hibás email vagy jelszó.";
        }
    }
}

?>

<form method="POST">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Login</button>
</form>