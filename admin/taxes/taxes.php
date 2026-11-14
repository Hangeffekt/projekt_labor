<?php
    $data = taxes();
    $taxes = $data['taxes'] ?? [];

    if (isset($_GET['tax_delete_id'])) {
        $id = $_GET['tax_delete_id'] ?? '';
        $id = preg_replace('/[^0-9]/', '', $id);

        if(empty(edit_tax($id))) {
            http_response_code(404);
            die('Hiba: a megadott azonosítóhoz nem található adó.');
        }

        delete_tax($id);
        header("Location: index.php?page=taxes&success=1");
        exit();
    }
?>
<a href="index.php?page=create_tax">Új adó létrehozása</a>
<?php include("error.php"); ?>
<?php if($taxes):?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Érték</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($taxes as $tax): ?>
                <tr>
                    <td><?= $tax['id'] ?></td>
                    <td><?= $tax['value'] ?></td>
                    <td>
                        <a href="index.php?page=edit_tax&id=<?= $tax['id'] ?>">Szerkesztés</a>
                        <a href="index.php?page=taxes&tax_delete_id=<?= $tax['id'] ?>">Törlés</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Nem található adó.</p>
<?php endif; ?>