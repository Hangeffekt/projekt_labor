<?php
    if(isset($_GET['id'])) {
        $id = preg_match('/[^0-9]/', $_GET['id']) ? null : $_GET['id'];
        if ($id === null) {
            echo "Érvénytelen felhasználó-azonosító.";
            exit;
        }
    } else {
        // Handle the case when 'id' is not provided in the URL
        echo "Hiányzik a felhasználó-azonosító.";
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

        if ($first_name == "" || $last_name == "" || $email == "" || $phone == "" || $irsz == "" || $address == "")
        // Check if any of the required parameters are empty
        $errors[] = "Hiba: egy vagy több kötelező mező hiányzik.";
        
        if( $email == "" || check_email(["email" => $email], $id)['db'] > 0)
            $errors[] = "Ez az e-mail-cím már használatban van.";
    

        $irsz = preg_replace('/[^0-9]/', '', $irsz);
        $invoice_irsz = preg_replace('/[^0-9]/', '', $invoice_irsz);
        $tax_number = preg_replace('/[^0-9]/', '', $tax_number);

        if($tax_number != ""){
            if(check_tax_number(['tax_number' => $tax_number], $id)['db'] > 0){
                $errors[] = "Ez az adószám már használatban van.";
            }
        }

        if(empty($errors)){
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
    }

    $data = edit_user($id);
    $user = $data["user"];
?>

<?php include("error.php"); ?>

<?php if ($user): ?>
    <form method="POST">
        <h2>Felhasználói adatok szerkesztése</h2>
        <div class="form-group">
            <label for="first_name">Keresztnév</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $user['first_name']; ?>">
        </div>
        <div class="form-group">
            <label for="last_name">Vezetéknév</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $user['last_name']; ?>">
        </div>
        <div class="form-group">
            <label for="email">E-mail-cím</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= $user['email']; ?>">
        </div>
        <div class="form-group">
            <label for="phone">Telefonszám</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?= $user['phone']; ?>">
        </div>
        <div class="form-group">
            <label for="password">Irányítószám</label>
            <input type="number" class="form-control" id="password" name="irsz" value="<?= $user['irsz']; ?>">
        </div>
        <div class="form-group">
            <label for="address">Cím</label>
            <input type="text" class="form-control" id="address" name="address" value="<?= $user['address']; ?>">
        </div>
        <h2>Számlázási adatok szerkesztése</h2>
        <div class="form-group">
            <label for="invoice_address">Számlázási cím</label>
            <input type="text" class="form-control" id="invoice_address" name="invoice_address" value="<?= $user['invoice_address']; ?>">
        </div>
        <div class="form-group">
            <label for="invoice_irsz">Számlázási irányítószám</label>
            <input type="number" class="form-control" id="invoice_irsz" name="invoice_irsz" value="<?= $user['invoice_irsz']; ?>">
        </div>
        <div class="form-group">
            <label for="name">Számlázási cégnév</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $user['name']; ?>">
        </div>
        <div class="form-group">
            <label for="tax_number">Adószám</label>
            <input type="text" class="form-control" id="tax_number" name="tax_number" value="<?= $user['tax_number']; ?>">
        </div>
        <button type="submit" name="update_user" class="btn btn-primary">Felhasználói adatok frissítése</button>
    </form>
<?php else: ?>
    <p>Nem található felhasználó.</p>
<?php endif; ?>
