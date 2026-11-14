<?php
    $data = admins();
    $admins = $data['admins'] ?? [];

    if (isset($_GET['admin_delete_id'])) {
        $id = $_GET['admin_delete_id'] ?? '';
        $id = preg_replace('/[^0-9]/', '', $id);

        if(empty(edit_admin($id))) {
            http_response_code(404);
            die('Hiba: a megadott azonosítóhoz nem található adminisztrátor.');
        }

        delete_admin($id);
        header("Location: index.php?page=admins&success=1");
        exit();
    }
?>
<a href="index.php?page=create_admin">Új adminisztrátor létrehozása</a>
<?php include("error.php"); ?>
<?php if($admins):?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Név</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($admins as $admin): ?>
                <tr>
                    <td><?= $admin['id'] ?></td>
                    <td><?= $admin['name'] ?></td>
                    <td>
                        <a href="index.php?page=edit_admin&id=<?= $admin['id'] ?>">Szerkesztés</a>
                        <a href="index.php?page=admins&admin_delete_id=<?= $admin['id'] ?>">Törlés</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Nem található adminisztrátor.</p>
<?php endif; ?>