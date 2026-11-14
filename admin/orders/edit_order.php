<?php
if(isset($_GET['id'])) {
    $id = preg_match('/^\d+$/', $_GET['id']) ? $_GET['id'] : null;
    if ($id === null) {
        // Handle invalid ID
        echo "Érvénytelen rendelésazonosító.";
        exit;
    }
} else {
    // Handle the case when 'id' is not provided in the URL
    echo "Hiányzik a rendelésazonosító.";
    exit;
}

if(isset($_POST['status'])) {
    $newStatus = $_POST['status'];
    update_order_status($id, $newStatus);

    header("Location: index.php?page=edit_order&id=$id");
    exit;
}
$data = edit_order($id);
$order = $data["order"] ?? null;
$user = $data["user"] ?? null;
$items = $data["order_items"] ?? [];
?>
<h2>Állapot módosítása</h2>
<?php if ($order): ?>
    <h1>Rendelés szerkesztése #<?php echo $order['id']; ?></h1>
    <form method="POST">
        <div class="form-group">
            <label for="status">Állapot</label>
            <select class="form-control" id="status" name="status">
                <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : ''; ?>>Függőben</option>
                <option value="processing" <?= $order['status'] === 'processing' ? 'selected' : ''; ?>>Feldolgozás alatt</option>
                <option value="completed" <?= $order['status'] === 'completed' ? 'selected' : ''; ?>>Teljesítve</option>
                <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : ''; ?>>Lemondva</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Rendelés frissítése</button>
    </form>

    <h1>A(z) #<?= $order['id']; ?> rendelés adatai</h1>
    
    <p><strong>Végösszeg:</strong> <?= $order['total_amount']; ?></p>
    <p><strong>Állapot:</strong> <?= admin_status_label($order['status']); ?></p>
    <p><strong>Létrehozás dátuma:</strong> <?= $order['created_at']; ?></p>
    <h2>Szállítási adatok</h2>
    <p><strong>Vásárló neve:</strong> <?= $order['first_name'] . ' ' . $order['last_name']; ?></p>
    <p><strong>Szállítási cím:</strong> <?= $order['address']; ?></p>
    <p><strong>Irányítószám:</strong> <?= $order['irsz']; ?></p>
    <p><strong>Település:</strong> <?= $order['city']; ?></p>
    <p><strong>Vásárló e-mail-címe:</strong> <?=  $order['email']; ?></p>
    <p><strong>Vásárló telefonszáma:</strong> <?= $order['phone']; ?></p>
    <h2>Számlázási adatok</h2>
    <?php if($order['invoice'] == 1) { ?>
        <p><strong>Számlázási cím:</strong> <?= $order['invoice_address']; ?></p>
        <p><strong>Számlázási irányítószám:</strong> <?= $order['invoice_irsz']; ?></p>
        <p><strong>Számlázási cégnév:</strong> <?= $order['name']; ?></p>
        <p><strong>Adószám:</strong> <?= $order['tax_number']; ?></p>
    <?php } else { ?>
        <p><strong>Vásárló neve:</strong> <?= $order['first_name'] . ' ' . $order['last_name']; ?></p>
        <p><strong>Szállítási cím:</strong> <?= $order['address']; ?></p>
        <p><strong>Irányítószám:</strong> <?= $order['irsz']; ?></p>
        <p><strong>Település:</strong> <?= $order['city']; ?></p>
        <p><strong>Vásárló e-mail-címe:</strong> <?=  $order['email']; ?></p>
        <p><strong>Vásárló telefonszáma:</strong> <?= $order['phone']; ?></p>
    <?php } ?>

    <a href="index.php?page=edit_user&id=<?= $order['id']; ?>">Vásárlói adatok szerkesztése</a>
    <?php else: ?>
        <p>A rendelés vagy a vásárló nem található.</p>
    <?php endif; ?>
    
    
    <h2>Rendelt termékek</h2>
    <?php if ($items): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Termék neve</th>
                <th scope="col">Mennyiség</th>
                <th scope="col">Ár</th>
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
        <p>Ehhez a rendeléshez nem található termék.</p>
    <?php endif; ?>
