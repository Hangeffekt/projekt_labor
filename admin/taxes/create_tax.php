<?php
require_once "../private/connect.php";
$errors = [];
$tax_value = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tax_value = $_POST['value'] ?? null;

    if ($tax_value == null) {
        http_response_code(400);
        $errors[] = 'Hiba: a value mező kötelező.';
    }

    if (checkTaxExists($tax_value)) {
        $errors[] = "Ez az érték már létezik.";
    }

    if ($errors == null) {
        $tax_value = preg_replace('/[^0-9.]/', '', $tax_value);
        if (!checkTaxExists($tax_value)) {
            createTax(['value' => $tax_value]);
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
    <input type="number" name="value" id="value" value="<?= $tax_value ?? '' ?>" required>
    <button type="submit">Create Tax</button>
</form>