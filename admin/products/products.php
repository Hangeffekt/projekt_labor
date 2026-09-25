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
            $errors[] = 'Hiba: a megadott id-hez nem található termék.';
        }
        else{
            delete_product($id);
            header("Location: index.php?page=products&success=1");
            exit();
        }
    }
?>
<a href="index.php?page=create_product">Create New Product</a>
<?php if($products):?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Visible</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($products as $product): ?>
                <tr>
                    <td><?= $product['id'] ?></td>
                    <td><?= $product['brand_name'] ?> <?= $product['product_name'] ?></td>
                    <td><?= $product['visible'] ? 'Yes' : 'No' ?></td>
                    <td>
                        <a href="index.php?page=edit_product&id=<?= $product['id'] ?>">Edit</a>
                        <a href="index.php?page=products&product_delete_id=<?= $product['id'] ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No products found.</p>
<?php endif; ?>