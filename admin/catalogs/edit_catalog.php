<?php
    $errors = [];
    if (!isset($_GET['id']) || $_GET['id'] === '') {
        http_response_code(400);
        die('Hiba: a id query paraméter kötelező.');
    }

    $data = edit_catalog($_GET['id']);
    $catalog = $data['catalog'] ?? [];

    if(empty($data['catalog'])) {
        http_response_code(404);
        $errors[] = 'Hiba: a megadott id-hez nem található katalógus.';
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_GET['id'] ?? '';
        $name = $_POST['name'] ?? '';
        $parent_id = $_POST['parent_id'] ?? '';
        $visible = isset($_POST['visible']) ? 1 : 0;

        if ($name !== null) {
            $name = preg_replace('/[^a-zA-Z0-9-]/', '', $name);
        }
        else {
            http_response_code(400);
            $errors[] = 'Hiba: a name mező kötelező.';
        }

        if ($parent_id !== null  && $parent_id !== '') {
            $parent_id = preg_replace('/[^0-9]/', '', $parent_id);
            if(empty(edit_catalog($parent_id))) {
                http_response_code(404);
                $errors[] = 'Hiba: a megadott parent id-hez nem található katalógus.';
            }
        }

        if ($visible === '1') {
            $visible = 1;
        } else {
            $visible = 0;
        }

        if (empty($errors)) {
            update_catalog(['name' => $name, 'parent_id' => $parent_id, 'visible' => $visible], $id);
            header("Location: index.php?page=catalogs&success=2");
            exit();
        }
    }
?>

<?php if (!empty($data)): ?>
    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?= $catalog[0]['name'] ?? '' ?>" required>
        <label for="parent_id">Parent:</label>
        <select name="parent_id" id="parent_id">
            <option value="">None</option>
            <?php
                $data = catalogs();
                $catalogs = $data['catalogs'] ?? [];
                foreach ($catalogs as $catalog): ?>
                    <option value="<?= $catalog['id'] ?>" <?= ($catalog[0]['parent_id'] ?? '') == $catalog['id'] ? 'selected' : '' ?>><?= $catalog['name'] ?></option>
            <?php endforeach; ?>
        </select>
        <input type="checkbox" name="visible" value="1" <?= ($catalog[0]['visible'] ?? 1) ? 'checked' : '' ?>> Visible
        <button type="submit">Update Catalog</button>
    </form>
<?php else: ?>
    <p><?= implode('<br>', $errors) ?></p>
<?php endif; ?>