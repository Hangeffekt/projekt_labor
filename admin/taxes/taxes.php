<?php
    $data = taxes();
    $taxes = $data['taxes'] ?? [];

    if (isset($_GET['tax_delete_id'])) {
        $id = $_GET['tax_delete_id'] ?? '';
        $id = preg_replace('/[^0-9]/', '', $id);

        if(empty(edit_tax($id))) {
            http_response_code(404);
            die('Hiba: a megadott id-hez nem található adó.');
        }

        delete_tax($id);
        header("Location: index.php?page=taxes&success=1");
        exit();
    }
?>

<?php if($taxes):?>
    <a href="index.php?page=create_tax">Create New Tax</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Value</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($taxes as $tax): ?>
                <tr>
                    <td><?= $tax['id'] ?></td>
                    <td><?= $tax['value'] ?></td>
                    <td>
                        <a href="index.php?page=edit_tax&id=<?= $tax['id'] ?>">Edit</a>
                        <a href="index.php?page=taxes&tax_delete_id=<?= $tax['id'] ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No taxes found.</p>
<?php endif; ?>