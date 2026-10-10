<?php 

    if(isset($_POST["create_user"])){
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

        if(check_email(["email" => $email]) || $email != null){
            $errors[] = "Az email cím már létezik";
        }

        $irsz = preg_replace('/[^0-9]/', '', $irsz);
        $invoice_irsz = preg_replace('/[^0-9]/', '', $invoice_irsz);
        $tax_number = preg_replace('/[^0-9]/', '', $tax_number);

        if(check_tax_number($tax_number) || $tax_number != null){
            $errors[] = "Az adószám már létezik";
        }

        if(empty($errors)){
            create_user(['first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'phone' => $phone,
            'irsz' => $irsz,
            'address' => $address,
            'invoice_address' => $invoice_address,
            'invoice_irsz' => $invoice_irsz,
            'name' => $name,
            'tax_number' => $tax_number,]);
        
            header("Location: index.php?page=users&success=3");
        }
    }
?>

<?php include("error.php"); ?>

<form method="POST">
        <h2>Create User Data</h2>
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="" require>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="" require>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="" require>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="" require>
        </div>
        <div class="form-group">
            <label for="irsz">Zip Code</label>
            <input type="number" class="form-control" id="irsz" name="irsz" value="">
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" value="">
        </div>
        <h2>Edit Invoice Data</h2>
        <div class="form-group">
            <label for="invoice_address">Invoice Address</label>
            <input type="text" class="form-control" id="invoice_address" name="invoice_address" value="">
        </div>
        <div class="form-group">
            <label for="invoice_irsz">Invoice Zip Code</label>
            <input type="number" class="form-control" id="invoice_irsz" name="invoice_irsz" value="">
        </div>
        <div class="form-group">
            <label for="name">Invoice Company Name</label>
            <input type="text" class="form-control" id="name" name="name" value="">
        </div>
        <div class="form-group">
            <label for="tax_number">Invoice Tax Number</label>
            <input type="text" class="form-control" id="tax_number" name="tax_number" value="">
        </div>
        <button type="submit" name="create_user" class="btn btn-primary">Create User</button>
    </form>