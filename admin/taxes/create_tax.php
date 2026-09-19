<?php
require_once "../private/connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = $_POST['value'] ?? null;

    if ($value !== null) {
        $value = preg_replace('/[^0-9.]/', '', $value);
        createTax(['value' => $value]);
        header("Location: index.php?page=taxes&success=3");
        exit();
    }
}
?>

<form method="POST">
    <label for="value">Value:</label>
    <input type="text" name="value" id="value" value="<?= $_POST['value'] ?? '' ?>" required>
    <button type="submit">Create Tax</button>
</form>