<?php

    if (!isset($_GET['id']) || $_GET['id'] === '') {
        http_response_code(400);
        die('Hiba: az azonosító megadása kötelező.');
    }

    $data = edit_brand($_GET['id']);
    $brand = $data['brand'] ?? [];
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_GET['id'] ?? '';
        $name = $_POST['name'] ?? '';

        if ($id === '' || $name === '') {
            http_response_code(400);
            $errors[] = 'Hiba: az azonosító és a név megadása kötelező.';
        }

        if(empty($data['brand'])) {
            http_response_code(404);
            $errors[] = 'Hiba: a megadott azonosítóhoz nem található márka.';
        }

        if (brand_exists($name)) {
            $errors[] = "Ez a név már létezik.";
        }

        if (empty($errors)) {
            $name = preg_replace('/[^a-zA-Z0-9-]/', '', $name);
            update_brand(['name' => $name ], $id);
            header("Location: index.php?page=brands&success=2");
            exit();
        }
    }
    include("error.php");
?>

<form method="POST">
    <label for="name">Név:</label>
    <input type="text" name="name" id="name" value="<?= $brand[0]['name'] ?? '' ?>" required>
    <button type="submit">Márka frissítése</button>
</form>