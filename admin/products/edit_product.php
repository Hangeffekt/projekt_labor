<?php
    $data = brands();
    $brands = $data['brands'] ?? [];
    $data = taxes();
    $taxes = $data['taxes'] ?? [];
    $data = catalogs();
    $catalogs = $data['catalogs'] ?? [];
    $errors = [];

    if (!isset($_GET['id']) || $_GET['id'] === '') {
        http_response_code(400);
        die('Hiba: a id query paraméter kötelező.');
    }

    $data = edit_product($_GET['id']);
    $product = $data['product'] ?? [];

    if(empty($data['product'])) {
        http_response_code(404);
        $errors[] = 'Hiba: a megadott id-hez nem található termék.';
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_GET['id'] ?? '';
        $brand_id = $_POST['brand'] ?? null;
        $name = $_POST['name'] ?? null;
        $tax_id = $_POST['tax'] ?? null;
        $catalog_id = $_POST['catalog'] ?? null;
        $ean = $_POST['ean'] ?? null;
        $sale_price = $_POST['sale_price'] ?? null;
        $visible = $_POST['visible'] ?? null;

        if ($brand_id === '' || $name === '' || $tax_id === '' || $catalog_id === '' || $ean === '' || $sale_price === '') {
            http_response_code(400);
            $errors[] = 'Hiba: minden mezőt ki kell tölteni.';
        }

        $data = edit_brand($brand_id);
        $brand_exists = $data['brand'] ?? [];
        if(empty($brand_exists)) {
            http_response_code(404);
            $errors[] = 'Hiba: a megadott id-hez nem található márka.';
        }

        $data = edit_tax($tax_id);
        $tax_exists = $data['tax'] ?? [];
        if(empty($tax_exists)) {
            http_response_code(404);
            $errors[] = 'Hiba: a megadott id-hez nem található adó.';
        }

        $data = edit_catalog($catalog_id);
        $catalog_exists = $data['catalog'] ?? [];
        if(empty($catalog_exists)) {
            http_response_code(404);
            $errors[] = 'Hiba: a megadott id-hez nem található katalógus.';
        }

        if ($name !== null && $ean !== null && $sale_price !== null) {
            $ean = preg_replace('/[^0-9]/', '', $ean);
            $sale_price = preg_replace('/[^0-9]/', '', $sale_price);
        }
        else {
            http_response_code(400);
            $errors[] = 'Hiba: a name, ean és sale_price mezők kötelezőek.';
        }

        if ($visible == '1') {
            $visible = 1;
        } else {
            $visible = 0;
        }

        if (empty($errors)) {
            update_product(['name' => $name,
            'brand_id' => $brand_id,
            'tax_id' => $tax_id,
            'catalog_id' => $catalog_id,
            'ean' => $ean,
            'sale_price' => $sale_price,
            'visible' => $visible], $id);
            header("Location: index.php?page=products&success=2");
            exit();
        }
    }
?>

<?php if (!empty($data)): ?>
    <form method="POST">
        <label for="brand">Brand:</label>
        <select name="brand" id="brand" required>
            <option value="">Select a brand:</option>
            <?php foreach ($brands as $brand): ?>
                <?php if ($brand['id'] == $product[0]['brand_id']): ?>
                    <option value="<?= $brand['id'] ?>" selected><?= $brand['name'] ?></option>
                <?php else: ?>
                    <option value="<?= $brand['id'] ?>"><?= $brand['name'] ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?= $_POST['name'] ?? $product[0]['product_name'] ?>" required>
        <label for="tax">Taxes:</label>
        <select name="tax" id="tax" required>
            <option value="">Select taxes:</option>
            <?php foreach ($taxes as $tax): ?>
                <?php if ($tax['id'] == $product[0]['tax_id']): ?>
                    <option value="<?= $tax['id'] ?>" selected><?= $tax['value'] ?></option>
                <?php else: ?>
                    <option value="<?= $tax['id'] ?>"><?= $tax['value'] ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <label for="catalog">Catalog:</label>
        <select name="catalog" id="catalog" required>
            <option value="">Select a catalog:</option>
            <?php foreach ($catalogs as $catalog): ?>
                <?php if ($catalog['id'] == $product[0]['catalog_id']): ?>
                    <option value="<?= $catalog['id'] ?>" selected><?= $catalog['name'] ?></option>
                <?php else: ?>
                    <option value="<?= $catalog['id'] ?>"><?= $catalog['name'] ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <label for="ean">EAN:</label>
        <input type="text" name="ean" id="ean" value="<?= $_POST['ean'] ?? $product[0]['ean'] ?>" required>
        <label for="sale_price">Sale Price:</label>
        <input type="text" name="sale_price" id="sale_price" value="<?= $_POST['sale_price'] ?? $product[0]['sale_price'] ?>" required>
        <input type="checkbox" name="visible" value="1" <?= $product[0]['visible'] == 1 ? 'checked' : '' ?>> Visible
        <button type="submit">Update Product</button>
    </form>
<?php else: ?>
    <p><?= implode('<br>', $errors) ?></p>
<?php endif; ?>