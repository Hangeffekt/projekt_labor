<?php
require_once "../private/connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = $_POST['value'] ?? null;

    if ($value !== null) {
        $value = preg_replace('/[^a-zA-Z0-9-]/', '', $value);
        createBrand(['name' => $value]);
        header("Location: index.php?page=brands&success=3");
        exit();
    }
}
?>

<form method="POST">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" value="<?= $_POST['name'] ?? '' ?>" required>
    <button type="submit">Create Brand</button>
</form>