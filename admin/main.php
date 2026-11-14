<?php
    $data = orders();
    $all_orders = $data["orders"];
    
    $latest_orders = ($all_orders != null) ? array_slice($all_orders, 0, 10) : null;
?>

<h2>Utolsó 10 rendelés</h2>

<table>
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
    <?php if($latest_orders != null): ?>
        <?php foreach($latest_orders as $order): ?>
            <tr>
                <td><?= htmlspecialchars($order['id']); ?></td>
                <td><?= htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></td>
                <td><?= htmlspecialchars($order['total_amount']); ?></td>
                <td><?= htmlspecialchars(admin_status_label($order['status'])); ?></td>
                <td><?= htmlspecialchars($order['created_at']); ?></td>
                <td>
                    <a href="index.php?page=edit_order&id=<?= $order['id']; ?>">Megtekintés</a>
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
