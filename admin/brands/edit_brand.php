<?php

    if (!isset($_GET['id']) || $_GET['id'] === '') {
        http_response_code(400);
        die('Hiba: a id query paraméter kötelező.');
    }

    $data = edit_brand($_GET['id']);
    $brand = $data['brand'] ?? [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_GET['id'] ?? '';
        $name = $_POST['name'] ?? '';

        if ($id === '' || $name === '') {
            http_response_code(400);
            $errors[] = 'Hiba: az id és name mezők kötelezőek.';
        }

        if(empty($data['brand'])) {
            http_response_code(404);
            $errors[] = 'Hiba: a megadott id-hez nem található márka.';
        }

        if (empty($errors)) {
            $name = preg_replace('/[^a-zA-Z0-9-]/', '', $name);
            update_brand(['name' => $name ], $id);
            header("Location: index.php?page=brands&success=2");
            exit();
        }
    }
?>

<form method="POST">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" value="<?= $brand[0]['name'] ?? '' ?>" required>
    <button type="submit">Update Brand</button>
</form>