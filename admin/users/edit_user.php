<?php
    if(isset($_GET['id'])) {
        $id = preg_match('/[^0-9]/', $_GET['id']) ? $_GET['id'] : null;
        if ($id === null) {
            echo "Invalid user ID.";
            exit;
        }
    } else {
        // Handle the case when 'id' is not provided in the URL
        echo "User ID is missing.";
        exit;
    }

    if(isset($_POST['update_user'])) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $irsz = $_POST['irsz'];
        $address = $_POST['address'];
        $invoice_address = $_POST['invoice_address'];
        $invoice_irsz = $_POST['invoice_irsz'];
        $name = $_POST['name'];
        $tax_number = $_POST['tax_number'];

        $irsz = preg_replace('/[^0-9]/', '', $irsz);
        $invoice_irsz = preg_replace('/[^0-9]/', '', $invoice_irsz);
        $tax_number = preg_replace('/[^0-9]/', '', $tax_number);

        update_user($id, [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'phone' => $phone,
            'irsz' => $irsz,
            'address' => $address,
            'invoice_address' => $invoice_address,
            'invoice_irsz' => $invoice_irsz,
            'name' => $name,
            'tax_number' => $tax_number,
        ]);
    }

    $data = edit_user($id);
    $user = $data["user"];
?>

<?php include("error.php"); ?>

<?php if ($user): ?>
    <form method="POST">
        <h2>Edit User Data</h2>
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $user['first_name']; ?>">
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $user['last_name']; ?>">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= $user['email']; ?>">
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?= $user['phone']; ?>">
        </div>
        <div class="form-group">
            <label for="password">Zip Code</label>
            <input type="number" class="form-control" id="password" name="irsz" value="<?= $user['irsz']; ?>">
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" value="<?= $user['address']; ?>">
        </div>
        <h2>Edit Invoice Data</h2>
        <div class="form-group">
            <label for="invoice_address">Invoice Address</label>
            <input type="text" class="form-control" id="invoice_address" name="invoice_address" value="<?= $user['invoice_address']; ?>">
        </div>
        <div class="form-group">
            <label for="invoice_irsz">Invoice Zip Code</label>
            <input type="number" class="form-control" id="invoice_irsz" name="invoice_irsz" value="<?= $user['invoice_irsz']; ?>">
        </div>
        <div class="form-group">
            <label for="name">Invoice Company Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $user['name']; ?>">
        </div>
        <div class="form-group">
            <label for="tax_number">Invoice Tax Number</label>
            <input type="text" class="form-control" id="tax_number" name="tax_number" value="<?= $user['tax_number']; ?>">
        </div>
        <button type="submit" name="update_user" class="btn btn-primary">Update User</button>
    </form>
<?php else: ?>
    <p>User not found.</p>
<?php endif; ?>