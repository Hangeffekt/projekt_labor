<?php
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? null;
    $parent_id = $_POST['parent'] ?? null;
    $visible = $_POST['visible'] ?? null;

    if ($name == null) {
        http_response_code(400);
        $errors[] = 'Hiba: a név megadása kötelező.';
    }

    if ($parent_id !== null  && $parent_id !== '') {
        $parent_id = preg_replace('/[^0-9]/', '', $parent_id);
        if(empty(edit_catalog($parent_id))) {
            http_response_code(404);
            $errors[] = 'Hiba: a megadott szülőkatalógus-azonosítóhoz nem található katalógus.';
        }
    }

    if ($visible == '1') {
        $visible = 1;
    } else {
        $visible = 0;
    }

    if (checkCatalogExists($name)) {
        $errors[] = "Ez a név már létezik.";
    }

    if (empty($errors)) {
        
        createCatalog(['name' => $name, 'parent_id' => $parent_id, 'visible' => $visible]);
        header("Location: index.php?page=catalogs&success=3");
        exit();
    }

}
include("error.php");
?>

<form method="POST">
    <label for="name">Név:</label>
    <input type="text" name="name" id="name" value="<?= $_POST['name'] ?? '' ?>" required>
    <label for="parent_id">Szülőkatalógus:</label>
    <select name="parent" id="parent_id">
        <option value="">Nincs</option>
        <?php
            $data = catalogs();
            $catalogs = $data['catalogs'] ?? [];
            foreach ($catalogs as $catalog): ?>
                <option value="<?= $catalog['id'] ?>"><?= $catalog['name'] ?></option>
            <?php endforeach; ?>
        </select>
    <input type="checkbox" name="visible" value="1"> Látható
    <button type="submit">Katalógus létrehozása</button>
</form>