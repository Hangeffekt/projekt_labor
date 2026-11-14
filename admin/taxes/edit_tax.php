<?php

    if (!isset($_GET['id']) || $_GET['id'] === '') {
        http_response_code(400);
        die('Hiba: az azonosító megadása kötelező.');
    }

    $data = edit_tax($_GET['id']);
    $tax = $data['tax'] ?? [];
    $errors = [];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_GET['id'] ?? '';
        $value = $_POST['value'] ?? '';

        if ($id === '' || $value === '') {
            http_response_code(400);
            $errors[] = 'Hiba: az azonosító és az érték megadása kötelező.';
        }

        if(empty($data['tax'])) {
            http_response_code(404);
            $errors[] = 'Hiba: a megadott azonosítóhoz nem található adó.';
        }

        if (checkTaxExists($value)) {
            $errors[] = "Ez az érték már létezik.";
        }

        if (empty($errors)) {
            $value = preg_replace('/[^0-9.]/', '', $value);
            update_tax(['value' => $value], $id);
            header("Location: index.php?page=taxes&success=2");
            exit();
        }
    }
    include("error.php");
?>

<form method="POST">
    <label for="value">Érték:</label>
    <input type="number" name="value" id="value" value="<?= $tax[0]['value'] ?? '' ?>" required>
    <button type="submit">Adó frissítése</button>
</form>