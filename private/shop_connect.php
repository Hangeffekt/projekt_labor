<?php
require_once "config.php";
try {
  $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

function load_page_file($page) {
    if(str_contains($page, 'main')) {
        return __DIR__ . "\..\\" . $page . ".php";
    }
    else if(str_contains($page, 'category')) {
        return __DIR__ . "\..\\" . $page . ".php";
    }
    else if(str_contains($page, 'product')) {
        return __DIR__ . "\..\\" . $page . ".php";
    }
    else if(str_contains($page, 'cart')) {
        return __DIR__ . "\..\\" . $page . ".php";
    }
    else if(str_contains($page, 'delivery')) {
        return __DIR__ . "\..\\" . $page . ".php";
    }
    else if(str_contains($page, 'payment')) {
        return __DIR__ . "\..\\" . $page . ".php";
    }
    return __DIR__ . "/index.php";
}

function load_categories($id) {
    global $conn;
    $data = [];
    $sql = $conn->prepare("SELECT * FROM catalogs WHERE parent_id = :id");
    $sql->execute(['id' => $id]);
    $data["categories"] = $sql->fetchAll(PDO::FETCH_ASSOC);

    return $data;
}

function get_category($id) {
    global $conn;
    $sql = $conn->prepare("SELECT * FROM catalogs WHERE id = :id");
    $sql->execute(['id' => $id]);

    return $sql->fetch(PDO::FETCH_ASSOC);
}

function main_page_products() {
    global $conn;
    $data = [];

    $sql = $conn->prepare("SELECT * FROM products 
    inner join brands on products.brand_id = brands.id
    where show_front_page = 1 and visible = 1 ORDER BY sale_price LIMIT 10");
    $sql->execute();
    $sql = $sql->fetchAll(PDO::FETCH_ASSOC);
    $data["products"] = $sql;

    return $data;
}

function category_products($id) {
    global $conn;
    $data = [];

    $sql = $conn->prepare("SELECT p.*, b.name as brand_name, t.value as tax_value FROM products p
    inner join brands b on p.brand_id = b.id 
    inner join taxes t on p.tax_id = t.id
    where p.catalog_id = :id and p.visible = 1 ORDER BY p.sale_price ");
    $sql->execute(['id' => $id]);
    $sql = $sql->fetchAll(PDO::FETCH_ASSOC);
    $data["products"] = $sql;

    return $data;
}

function product_details($id) {
    global $conn;
    $data = [];

    $sql = $conn->prepare("SELECT p.*, b.name as brand_name, t.value as tax_value FROM products p
    inner join brands b on p.brand_id = b.id
    inner join taxes t on p.tax_id = t.id
    where p.id = :id and p.visible = 1");
    $sql->execute(['id' => $id]);
    $sql = $sql->fetch(PDO::FETCH_ASSOC);
    $data["product"] = $sql;

    return $data;
}