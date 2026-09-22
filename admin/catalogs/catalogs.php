<?php
    $data = catalogs();
    $catalogs = $data['catalogs'] ?? [];

    if (isset($_GET['catalog_delete_id'])) {
        $id = $_GET['catalog_delete_id'] ?? '';
        $id = preg_replace('/[^0-9]/', '', $id);

        if(empty(edit_catalog($id))) {
            http_response_code(404);
            die('Hiba: a megadott id-hez nem található katalógus.');
        }

        delete_catalog($id);
        header("Location: index.php?page=catalogs&success=1");
        exit();
    }
?>
<a href="index.php?page=create_catalog">Create New Catalog</a>
<?php if($catalogs):?>
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
            <?php foreach($catalogs as $catalog): ?>
                <tr>
                    <td><?= $catalog['id'] ?></td>
                    <td><?= $catalog['name'] ?></td>
                    <td><?= $catalog['visible'] ? 'Yes' : 'No' ?></td>
                    <td>
                        <a href="index.php?page=edit_catalog&id=<?= $catalog['id'] ?>">Edit</a>
                        <a href="index.php?page=catalogs&catalog_delete_id=<?= $catalog['id'] ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No catalogs found.</p>
<?php endif; ?>