<?php
$errors = [];

if (!isset($_GET['id']) || $_GET['id'] === '') {
    http_response_code(400);
    die('Hiba: a id query paraméter kötelező.');
}

$data = edit_delivery($_GET['id']);
$delivery = $data['brand'] ?? [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST["eanbtn"])){
        $ean = $_POST['ean'] ?? '';
        $id = search_by_ean($ean);
        if(count($id) == 1)
            add_to_deliverylist($id["id"]);
        else
            $errors[] = "Nem található termék az vonalkódhoz!";
    }
}
?>
<?php include("error.php"); ?>
<form method="post">
    <label for="ean">Ean:</label>
    <input type="number" name="ean">
    <input type="submit" name="eanbtn" value="Keresés">
</form>

<form method="post">
    <label for="ean">Márka:</label>
    <label for="ean">Név:</label>
    <label for="ean">Ár:</label>
    <input type="submit" name="searchbtn" value="Keresés">
</form>