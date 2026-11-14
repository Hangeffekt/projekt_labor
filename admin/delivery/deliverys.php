<?php
    $data = deliverys();
    $deliverys = $data['deliverys'] ?? [];

    if (isset($_GET['delivery_delete_id'])) {
        $id = $_GET['delivery_delete_id'] ?? '';
        $id = preg_replace('/[^0-9]/', '', $id);

        if(empty(edit_delivery($id))) {
            http_response_code(404);
            die('Hiba: a megadott azonosítóhoz nem található szállítmány.');
        }

        delete_delivery($id);
        header("Location: index.php?page=deliverys&success=1");
        exit();
    }

    if (isset($_GET['delivery_close_id'])) {
        $id = $_GET['delivery_close_id'] ?? '';
        $id = preg_replace('/[^0-9]/', '', $id);

        if(empty(edit_delivery($id))) {
            http_response_code(404);
            die('Hiba: a megadott azonosítóhoz nem található szállítmány.');
        }

        close_delivery($id);
        header("Location: index.php?page=deliverys&success=4");
        exit();
    }
?>
<a href="index.php?page=create_delivery">Új szállítmány létrehozása</a><br>
<?php include("error.php"); ?>

<?php if($deliverys):?>
    <?php foreach($deliverys as $delivery): ?>
        
            <?= $delivery['id'] ?>
            <?= $delivery['name'] ?>
            <?= admin_status_label($delivery['status']) ?>
            <?= $delivery['arriving_at'] ?>
            <?= $delivery['created_at'] ?>
            
                <a href="index.php?page=edit_delivery&id=<?= $delivery['id'] ?>">Szerkesztés</a>
                <?= $delivery['status'] == 'COMPLETED' ? '' : '<a href="index.php?page=deliverys&delivery_close_id='.$delivery['id'].'">Lezárás</a>' ?>
                <?= $delivery['status'] == 'COMPLETED' ? '<a href="index.php?page=delivery_storno&id='.$delivery['id'].'">Storno</a>' : '<a href="index.php?page=deliverys&delivery_delete_id='.$delivery['id'].'">Törlés</a>' ?>
            <br>
    <?php endforeach; ?>
<?php else: ?>
    <p>Nem található szállítmány.</p>
<?php endif; ?>