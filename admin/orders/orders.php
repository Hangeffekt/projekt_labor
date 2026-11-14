<?php
    $data = orders();
    $orders = $data["orders"];
?>
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Rendelésazonosító</th>
            <th scope="col">Vásárló neve</th>
            <th scope="col">Végösszeg</th>
            <th scope="col">Állapot</th>
            <th scope="col">Létrehozás dátuma</th>
            <th scope="col">Művelet</th>
        </tr>
    </thead>
    <tbody>
<?php
    if($orders != null): ?>
    
    <?php foreach($orders as $order): ?>
        <tr>
            <td><?= $order['id']; ?></td>
            <td><?= $order['first_name']; ?> <?= $order['last_name']; ?></td>
            <td><?= $order['total_amount']; ?></td>
            <td><?= admin_status_label($order['status']); ?></td>
            <td><?= $order['created_at']; ?></td>
            <td>
                <a href="index.php?page=edit_order&id=<?= $order['id']; ?>" class="btn btn-primary">Megtekintés</a>
            </td>
        </tr>  
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="6">Nem található rendelés.</td>
    </tr>
<?php endif; ?>
    </tbody>
    </table>
