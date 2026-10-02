<?php
require_once "../private/connect.php";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = $_POST['name'] ?? null;

    if($value == null){
        http_response_code(400);
        $errors[] = 'Hiba: a name mező kötelező.';
    }

    if(brand_exists($value)){
        $errors[] = "Ez a név már létezik.";
    }

    if($errors == null){
        createBrand(['name' => $value]);
        header("Location: index.php?page=brands&success=3");
        exit();
    }
}
include("error.php");
?>

<form method="POST">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" value="<?= $_POST['name'] ?? '' ?>" required>
    <button type="submit">Create Brand</button>
</form>