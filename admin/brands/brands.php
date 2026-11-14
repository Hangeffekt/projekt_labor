<?php
    $data = brands();
    $brands = $data['brands'] ?? [];

    if (isset($_GET['brand_delete_id'])) {
        $id = $_GET['brand_delete_id'] ?? '';
        $id = preg_replace('/[^0-9]/', '', $id);

        if(empty(edit_brand($id))) {
            http_response_code(404);
            die('Hiba: a megadott azonosítóhoz nem található márka.');
        }

        delete_brand($id);
        header("Location: index.php?page=brands&success=1");
        exit();
    }
?>
<a href="index.php?page=create_brand">Új márka létrehozása</a>
<?php include("error.php"); ?>
<?php if($brands):?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Név</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($brands as $brand): ?>
                <tr>
                    <td><?= $brand['id'] ?></td>
                    <td><?= $brand['name'] ?></td>
                    <td>
                        <a href="index.php?page=edit_brand&id=<?= $brand['id'] ?>">Szerkesztés</a>
                        <a href="index.php?page=brands&brand_delete_id=<?= $brand['id'] ?>">Törlés</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Nem található márka.</p>
<?php endif; ?>