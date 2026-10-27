<?php
    $data = deliverys();
    $deliverys = $data['deliverys'] ?? [];

    if (isset($_GET['delivery_delete_id'])) {
        $id = $_GET['delivery_delete_id'] ?? '';
        $id = preg_replace('/[^0-9]/', '', $id);

        if(empty(edit_delivery($id))) {
            http_response_code(404);
            die('Hiba: a megadott id-hez nem található szállítás.');
        }

        delete_delivery($id);
        header("Location: index.php?page=deliverys&success=1");
        exit();
    }
?>
<a href="index.php?page=create_delivery">Create New Delivery</a>
<?php include("error.php"); ?>

<?php if($deliverys):?>
    <?php foreach($deliverys as $delivery): ?>
        
            <?= $delivery['id'] ?>
            <?= $delivery['name'] ?>
            
                <a href="index.php?page=edit_delivery&id=<?= $delivery['id'] ?>">Edit</a>
                <?= $delivery['finished'] ? '' : '<a href="index.php?page=deliverys&delivery_delete_id='.$delivery['id'].'">Delete</a>' ?>
    <?php endforeach; ?>
<?php else: ?>
    <p>No deliverys found.</p>
<?php endif; ?>