<?php
    $data = orders();
    $all_orders = $data["orders"];
    
    $latest_orders = ($all_orders != null) ? array_slice($all_orders, 0, 10) : null;
?>

<h2 style="margin-bottom: 15px">Utolsó 10 rendelés</h2>

<table>
    <thead>
        <tr>
            <th scope="col">Order ID</th>
            <th scope="col">Customer Name</th>
            <th scope="col">Total Amount</th>
            <th scope="col">Status</th>
            <th scope="col">Created At</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
    <?php if($latest_orders != null): ?>
        <?php foreach($latest_orders as $order): ?>
            <tr>
                <td><?= htmlspecialchars($order['id']); ?></td>
                <td><?= htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></td>
                <td><?= htmlspecialchars($order['total_amount']); ?></td>
                <td><?= htmlspecialchars($order['status']); ?></td>
                <td><?= htmlspecialchars($order['created_at']); ?></td>
                <td>
                    <a href="index.php?page=edit_order&id=<?= $order['id']; ?>">View</a>
                </td>
            </tr>  
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="6">No orders found.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
