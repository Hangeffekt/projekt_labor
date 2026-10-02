<?php
require_once "../private/connect.php";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = $_POST['value'] ?? null;

    if ($value == null) {
        http_response_code(400);
        $errors[] = 'Hiba: a value mező kötelező.';
    }

    if (checkTaxExists($value)) {
        $errors[] = "Ez az érték már létezik.";
    }

    if ($errors == null) {
        $value = preg_replace('/[^0-9.]/', '', $value);
        if (!checkTaxExists($value)) {
            createTax(['value' => $value]);
            header("Location: index.php?page=taxes&success=3");
            exit();
        } else {
            $errors[] = "Ez az érték már létezik.";
        }
    }
}
include("error.php");
?>

<form method="POST">
    <label for="value">Value:</label>
    <input type="number" name="value" id="value" value="<?= $_POST['value'] ?? '' ?>" required>
    <button type="submit">Create Tax</button>
</form>