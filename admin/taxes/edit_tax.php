<?php

    if (!isset($_GET['id']) || $_GET['id'] === '') {
        http_response_code(400);
        die('Hiba: a id query paraméter kötelező.');
    }

    $data = edit_tax($_GET['id']);
    $tax = $data['tax'] ?? [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_GET['id'] ?? '';
        $value = $_POST['value'] ?? '';

        if ($id === '' || $value === '') {
            http_response_code(400);
            $errors[] = 'Hiba: az id és value mezők kötelezőek.';
        }

        if(empty($data['tax'])) {
            http_response_code(404);
            $errors[] = 'Hiba: a megadott id-hez nem található adó.';
        }

        if (empty($errors)) {
            $value = preg_replace('/[^0-9.]/', '', $value);
            update_tax(['value' => $value], $id);
            header("Location: index.php?page=taxes&success=2");
            exit();
        }
    }
?>

<form method="POST">
    <label for="value">Value:</label>
    <input type="text" name="value" id="value" value="<?= $tax[0]['value'] ?? '' ?>" required>
    <button type="submit">Update Tax</button>
</form>