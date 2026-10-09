<?php
if(isset($_GET['id'])) {
    $id = preg_match('/^\d+$/', $_GET['id']) ? $_GET['id'] : null;
    if ($id === null) {
        // Handle invalid ID
        echo "Invalid order ID.";
        exit;
    }
} else {
    // Handle the case when 'id' is not provided in the URL
    echo "Order ID is missing.";
    exit;
}

if(isset($_POST['status'])) {
    $newStatus = $_POST['status'];
    update_order_status($id, $newStatus);

    header("Location: index.php?page=edit_order&id=$id");
    exit;
}
$data = edit_order($id);
$order = $data["order"];
$user = $data["user"];
$items = $data["order_items"];
?>
<h2>Change status</h2>
<?php if ($order): ?>
    <h1>Edit Order #<?php echo $order['id']; ?></h1>
    <form method="POST">
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status">
                <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                <option value="processing" <?= $order['status'] === 'processing' ? 'selected' : ''; ?>>Processing</option>
                <option value="completed" <?= $order['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Order</button>
    </form>

    <h1>Order Details for Order #<?= $order['id']; ?></h1>
    
    <p><strong>Total Amount:</strong> <?= $order['total_amount']; ?></p>
    <p><strong>Status:</strong> <?= $order['status']; ?></p>
    <p><strong>Created At:</strong> <?= $order['created_at']; ?></p>
    <h2>Delivery datas</h2>
    <p><strong>Customer Name:</strong> <?= $order['first_name'] . ' ' . $order['last_name']; ?></p>
    <p><strong>Delivery Address:</strong> <?= $order['address']; ?></p>
    <p><strong>ZIP Code:</strong> <?= $order['irsz']; ?></p>
    <p><strong>City:</strong> <?= $order['city']; ?></p>
    <p><strong>Customer Email:</strong> <?=  $order['email']; ?></p>
    <p><strong>Customer Phone:</strong> <?= $order['phone']; ?></p>
    <h2>Invoice datas</h2>
    <?php if($order['invoice'] == 1) { ?>
        <p><strong>Invoice Address:</strong> <?= $order['invoice_address']; ?></p>
        <p><strong>Invoice ZIP Code:</strong> <?= $order['invoice_irsz']; ?></p>
        <p><strong>Invoice Company Name:</strong> <?= $order['name']; ?></p>
        <p><strong>Invoice Tax Number:</strong> <?= $order['tax_number']; ?></p>
    <?php } else { ?>
        <p><strong>Customer Name:</strong> <?= $order['first_name'] . ' ' . $order['last_name']; ?></p>
        <p><strong>Delivery Address:</strong> <?= $order['address']; ?></p>
        <p><strong>ZIP Code:</strong> <?= $order['irsz']; ?></p>
        <p><strong>City:</strong> <?= $order['city']; ?></p>
        <p><strong>Customer Email:</strong> <?=  $order['email']; ?></p>
        <p><strong>Customer Phone:</strong> <?= $order['phone']; ?></p>
    <?php } ?>

    <a href="index.php?page=edit_user&id=<?= $order['id']; ?>">Edit user data</a>
    <?php else: ?>
        <p>Order or user not found.</p>
    <?php endif; ?>
    
    
    <h2>Order Items</h2>
    <?php if ($items): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Item Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= $item['product_name']; ?></td>
                    <td><?= $item['qty']; ?></td>
                    <td><?= $item['price']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>No items found for this order.</p>
    <?php endif; ?>