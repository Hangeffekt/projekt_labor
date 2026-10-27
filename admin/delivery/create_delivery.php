<?php
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? null;
    $arriving_at = $_POST['arriving_at'] ?? null;

    if ($name == null){
        http_response_code(400);
        $errors[] = 'Hiba: a name mező kötelező.';
    }

    if ($arriving_at == null)
    {
        http_response_code(400);
        $errors[] = 'Hiba: a arriving_at mező kötelező.';
    }

    if (empty($errors)){
        
        createDelivery(['name' => $name, 'arriving_at' => $arriving_at]);
        header("Location: index.php?page=deliverys&success=3");
        exit();
    }
}
?>

<form method="POST">
    <label for="name">Név:</label>
    <input type="text" name="name" id="name" value="<?= $_POST['name'] ?? '' ?>" required>
    <label for="parent_id">Beérkezés dátuma:</label>
    <input type="date" name="arriving_at" required>
    <button type="submit">Create Delivery</button>
</form>