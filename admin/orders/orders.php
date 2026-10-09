<?php
    $data = orders();
    $orders = $data["orders"];
?>
<table class="table table-striped">
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
<?php
    if($orders != null): ?>
    
    <?php foreach($orders as $order): ?>
        <tr>
            <td><?= $order['id']; ?></td>
            <td><?= $order['first_name']; ?> <?= $order['last_name']; ?></td>
            <td><?= $order['total_amount']; ?></td>
            <td><?= $order['status']; ?></td>
            <td><?= $order['created_at']; ?></td>
            <td>
                <a href="index.php?page=edit_order&id=<?= $order['id']; ?>" class="btn btn-primary">View</a>
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
