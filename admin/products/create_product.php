<?php
require_once "../private/connect.php";
$data = brands();
$brands = $data['brands'] ?? [];
$data = taxes();
$taxes = $data['taxes'] ?? [];
$data = catalogs();
$catalogs = $data['catalogs'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        create_product([
            'brand_id' => $brand_id,
            'product_name' => $name,
            'tax_id' => $tax_id,
            'catalog_id' => $catalog_id,
            'ean' => $ean,
            'sale_price' => $sale_price,
            'visible' => $visible,
        ]);
        header("Location: index.php?page=products&success=3");
        exit();
    }
}
?>

<form method="POST">
    <label for="brand">Brand:</label>
    <select name="brand" id="brand" required>
        <option value="">Select a brand:</option>
        <?php foreach ($brands as $brand): ?>
            <option value="<?= $brand['id'] ?>"><?= $brand['name'] ?></option>
        <?php endforeach; ?>
    </select>
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" value="<?= $_POST['name'] ?? '' ?>" required>
    <label for="tax">Taxes:</label>
    <select name="tax" id="tax" required>
        <option value="">Select taxes:</option>
        <?php foreach ($taxes as $tax): ?>
            <option value="<?= $tax['id'] ?>"><?= $tax['value'] ?></option>
        <?php endforeach; ?>
    </select>
    <label for="catalog">Catalog:</label>
    <select name="catalog" id="catalog" required>
        <option value="">Select a catalog:</option>
        <?php foreach ($catalogs as $catalog): ?>
            <option value="<?= $catalog['id'] ?>"><?= $catalog['name'] ?></option>
        <?php endforeach; ?>
    </select>
    <label for="ean">EAN:</label>
    <input type="text" name="ean" id="ean" value="<?= $_POST['ean'] ?? '' ?>" required>
    <label for="sale_price">Sale Price:</label>
    <input type="text" name="sale_price" id="sale_price" value="<?= $_POST['sale_price'] ?? '' ?>" required>
    <input type="checkbox" name="visible" value="1"> Visible
    <button type="submit">Create Product</button>
</form>