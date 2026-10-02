<?php
    $data = admins();
    $admins = $data['admins'] ?? [];

    if (isset($_GET['admin_delete_id'])) {
        $id = $_GET['admin_delete_id'] ?? '';
        $id = preg_replace('/[^0-9]/', '', $id);

        if(empty(edit_admin($id))) {
            http_response_code(404);
            die('Hiba: a megadott id-hez nem található admin.');
        }

        delete_admin($id);
        header("Location: index.php?page=admins&success=1");
        exit();
    }
?>
<a href="index.php?page=create_admin">Create New Admin</a>
<?php include("error.php"); ?>
<?php if($admins):?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($admins as $admin): ?>
                <tr>
                    <td><?= $admin['id'] ?></td>
                    <td><?= $admin['name'] ?></td>
                    <td>
                        <a href="index.php?page=edit_admin&id=<?= $admin['id'] ?>">Edit</a>
                        <a href="index.php?page=admins&admin_delete_id=<?= $admin['id'] ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No admins found.</p>
<?php endif; ?>