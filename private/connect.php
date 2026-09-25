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
    if(str_contains($page, 'tax')) {
        return __DIR__ . "\..\admin\\taxes\\{$page}.php";
    }
    else if(str_contains($page, 'brand')) {
        return __DIR__ . "\..\admin\\brands\\{$page}.php";
    }
    else if(str_contains($page, 'catalog')) {
        return __DIR__ . "\..\admin\\catalogs\\{$page}.php";
    }
    else if(str_contains($page, 'product')) {
        return __DIR__ . "\..\admin\\products\\{$page}.php";
    }
    return __DIR__ . "/index.php";
}

function last_ten_orders(){
    global $conn;
    $data = [];
    $sql = $conn->prepare("SELECT * FROM orders LIMIT 10");

    $sql->execute();
    $data["orders"] = $sql->fetchAll(PDO::FETCH_ASSOC);

    return $data;
}

function taxes(){
    global $conn;
    $data = [];
    $sql = $conn->prepare("SELECT * FROM taxes");

    $sql->execute();
    $data["taxes"] = $sql->fetchAll(PDO::FETCH_ASSOC);

    return $data;
}

function createTax($data){
  global $conn;
  
  $sql = $conn->prepare("INSERT INTO `taxes` (`value`) VALUES (:value)");
  $sql->execute([
    ...$data
  ]);
}

function edit_tax($id) {
    global $conn;
    $data = [];
    $sql = $conn->prepare("SELECT * FROM taxes WHERE id = :id");

    $sql->execute(["id" => $id]);
    $data["tax"] = $sql->fetchAll(PDO::FETCH_ASSOC);

    return $data;
}

function update_tax($data, $id){
  global $conn;
  
  $sql = $conn->prepare("UPDATE taxes 
                        SET value = :value
                        WHERE id = :id");
  $sql->execute([
      ...$data,
      "id" => $id
    ]);
}

function delete_tax($id) {
    global $conn;
    
    $sql = $conn->prepare("DELETE FROM taxes 
                          WHERE id = :id");
    $sql->execute(["id" => $id]);
}

function brands(){
    global $conn;
    $data = [];
    $sql = $conn->prepare("SELECT * FROM brands");

    $sql->execute();
    $data["brands"] = $sql->fetchAll(PDO::FETCH_ASSOC);

    return $data;
}

function createBrand($data){
  global $conn;
  
  $sql = $conn->prepare("INSERT INTO `brands` (`name`) VALUES (:name)");
  $sql->execute([
    ...$data
  ]);
}

function edit_brand($id) {
    global $conn;
    $data = [];
    $sql = $conn->prepare("SELECT * FROM brands WHERE id = :id");

    $sql->execute(["id" => $id]);
    $data["brand"] = $sql->fetchAll(PDO::FETCH_ASSOC);

    return $data;
}

function update_brand($data, $id){
  global $conn;
  
  $sql = $conn->prepare("UPDATE brands 
                        SET name = :name
                        WHERE id = :id");
  $sql->execute([
      ...$data,
      "id" => $id
    ]);
}

function delete_brand($id) {
    global $conn;
    
    $sql = $conn->prepare("DELETE FROM brands 
                          WHERE id = :id");
    $sql->execute(["id" => $id]);
}

function catalogs(){
    global $conn;
    $data = [];
    $sql = $conn->prepare("SELECT * FROM catalogs");

    $sql->execute();
    $data["catalogs"] = $sql->fetchAll(PDO::FETCH_ASSOC);

    return $data;
}

function createCatalog($data){
  global $conn;
  
  $sql = $conn->prepare("INSERT INTO `catalogs` (`name`, `parent_id`, `visible`) VALUES (:name, :parent_id, :visible)");
  $sql->execute([
    ...$data
  ]);
}

function edit_catalog($id) {
    global $conn;
    $data = [];
    $sql = $conn->prepare("SELECT * FROM catalogs WHERE id = :id");

    $sql->execute(["id" => $id]);
    $data["catalog"] = $sql->fetchAll(PDO::FETCH_ASSOC);

    return $data;
}

function update_catalog($data, $id){
  global $conn;
  
  $sql = $conn->prepare("UPDATE catalogs 
                        SET name = :name, parent_id = :parent_id, visible = :visible
                        WHERE id = :id");
  $sql->execute([
      ...$data,
      "id" => $id
    ]);
}

function delete_catalog($id) {
    global $conn;
    
    $sql = $conn->prepare("DELETE FROM catalogs 
                          WHERE id = :id");
    $sql->execute(["id" => $id]);
}

function products(){
    global $conn;
    $data = [];
    $sql = $conn->prepare("SELECT products.*, b.name AS brand_name, c.name AS catalog_name FROM products
        LEFT JOIN brands b ON products.brand_id = b.id
        LEFT JOIN catalogs c ON products.catalog_id = c.id");

    $sql->execute();
    $data["products"] = $sql->fetchAll(PDO::FETCH_ASSOC);

    return $data;
}

function create_product($data){
  global $conn;
  
  $sql = $conn->prepare("INSERT INTO `products` (`brand_id`, `product_name`, `tax_id`, `catalog_id`, `ean`, `sale_price`, `visible`) VALUES (:brand_id, :product_name, :tax_id, :catalog_id, :ean, :sale_price, :visible)");
  $sql->execute([
    ...$data
  ]);
}

function edit_product($id) {
    global $conn;
    $data = [];
    $sql = $conn->prepare("SELECT * FROM products WHERE id = :id");

    $sql->execute(["id" => $id]);
    $data["product"] = $sql->fetchAll(PDO::FETCH_ASSOC);

    return $data;
}

function update_product($data, $id){
  global $conn;
  
  $sql = $conn->prepare("UPDATE products 
                        SET product_name = :name, brand_id = :brand_id, tax_id = :tax_id, catalog_id = :catalog_id, ean = :ean, sale_price = :sale_price, visible = :visible
                        WHERE id = :id");
  $sql->execute([
      ...$data,
      "id" => $id
    ]);
}

function delete_product($id) {
    global $conn;
    
    $sql = $conn->prepare("DELETE FROM products 
                          WHERE id = :id");
    $sql->execute(["id" => $id]);
}
?>