<?php
    $data = products();
    $products = $data['products'] ?? [];

    if (isset($_GET['product_delete_id'])) {
        $id = $_GET['product_delete_id'] ?? '';
        $id = preg_replace('/[^0-9]/', '', $id);

        $data = edit_product($id);
        $product_exists = $data['product'] ?? [];
        if(empty($product_exists)) {
            http_response_code(404);
            $errors[] = 'Hiba: a megadott azonosítóhoz nem található termék.';
        }
        else{
            delete_product($id);
            header("Location: index.php?page=products&success=1");
            exit();
        }
    }
?>
<a href="index.php?page=create_product">Új termék létrehozása</a>
<?php include("error.php"); ?>
<?php if($products):?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Név</th>
                <th>Látható</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($products as $product): ?>
                <tr>
                    <td><?= $product['id'] ?></td>
                    <td><?= $product['brand_name'] ?> <?= $product['product_name'] ?></td>
                    <td><?= $product['visible'] ? 'Igen' : 'Nem' ?></td>
                    <td>
                        <a href="index.php?page=edit_product&id=<?= $product['id'] ?>">Szerkesztés</a>
                        <a href="index.php?page=products&product_delete_id=<?= $product['id'] ?>">Törlés</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Nem található termék.</p>
<?php endif; ?>