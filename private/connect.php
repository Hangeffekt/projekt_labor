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
    else if(str_contains($page, 'main')) {
        return __DIR__ . "\..\admin\\{$page}.php";
    }
    else if(str_contains($page, 'admin')) {
        return __DIR__ . "\..\admin\\adminpages\\{$page}.php";
    }
    else if(str_contains($page, 'order')) {
        return __DIR__ . "\..\admin\\orders\\{$page}.php";
    }
    else if(str_contains($page, 'login')) {
        return __DIR__ . "\..\admin\\login.php";
    }
    else if(str_contains($page, 'orders')) {
        return __DIR__ . "\..\admin\\orders\\{$page}.php";
    }
    else if(str_contains($page, 'user')) {
        return __DIR__ . "\..\admin\\users\\{$page}.php";
    }
    else {
        http_response_code(404);
        die('Hiba: az oldal nem található.');
    }
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
    $sql = $conn->prepare("SELECT * FROM taxes
    order BY value ASC");

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

function checkTaxExists($value) {
    global $conn;
    $sql = $conn->prepare("SELECT COUNT(*) FROM taxes WHERE value = :value");
    $sql->execute(['value' => $value]);
    return $sql->fetchColumn() > 0;
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
    $sql = $conn->prepare("SELECT * FROM brands
    order BY name ASC");

    $sql->execute();
    $data["brands"] = $sql->fetchAll(PDO::FETCH_ASSOC);

    return $data;
}

function brand_exists($name) {
    global $conn;
    $sql = $conn->prepare("SELECT COUNT(*) FROM brands WHERE name = :name");
    $sql->execute(['name' => $name]);
    return $sql->fetchColumn() > 0;
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
    $sql = $conn->prepare("SELECT * FROM catalogs
    order BY name ASC");

    $sql->execute();
    $data["catalogs"] = $sql->fetchAll(PDO::FETCH_ASSOC);

    return $data;
}

function checkCatalogExists($name) {
    global $conn;
    $sql = $conn->prepare("SELECT COUNT(*) FROM catalogs WHERE name = :name");
    $sql->execute(['name' => $name]);
    return $sql->fetchColumn() > 0;
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

function checkProductExists($name) {
    global $conn;
    $sql = $conn->prepare("SELECT COUNT(*) FROM products WHERE product_name = :name");
    $sql->execute(['name' => $name]);
    return $sql->fetchColumn() > 0;
}

function checkEanExists($ean) {
    global $conn;
    $sql = $conn->prepare("SELECT COUNT(*) FROM products WHERE ean = :ean");
    $sql->execute(['ean' => $ean]);
    return $sql->fetchColumn() > 0;
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

function admins(){
    global $conn;
    $data = [];
    $sql = $conn->prepare("SELECT * FROM admins
    order BY name ASC");

    $sql->execute();
    $data["admins"] = $sql->fetchAll(PDO::FETCH_ASSOC);

    return $data;
}

function checkAdminExists($email) {
    global $conn;
    $sql = $conn->prepare("SELECT COUNT(*) FROM admins WHERE email = :email");
    $sql->execute(['email' => $email]);
    return $sql->fetchColumn() > 0;
}

function create_admin($data){
  global $conn;
  
  $sql = $conn->prepare("INSERT INTO `admins` (`name`, `email`, `password`) VALUES (:name, :email, :password)");
  $sql->execute([
    ...$data
  ]);
}

function edit_admin($id) {
    global $conn;
    $data = [];
    $sql = $conn->prepare("SELECT * FROM admins WHERE id = :id");

    $sql->execute(["id" => $id]);
    $data["admin"] = $sql->fetchAll(PDO::FETCH_ASSOC);

    return $data;
}

function update_admin($data, $id){
  global $conn;
  
  $sql = $conn->prepare("UPDATE admins 
                        SET name = :name, email = :email
                        WHERE id = :id");
  $sql->execute([
      ...$data,
      "id" => $id
    ]);
}

function delete_admin($id) {
    global $conn;
    
    $sql = $conn->prepare("DELETE FROM admins 
                          WHERE id = :id");
    $sql->execute(["id" => $id]);
}

function getAdminByEmail($email) {
    global $conn;
    $sql = $conn->prepare("SELECT * FROM admins WHERE email = :email");
    $sql->execute(['email' => $email]);
    return $sql->fetch(PDO::FETCH_ASSOC);
}

function orders(){
    global $conn;
    $data = [];

    $sql = $conn->prepare("SELECT o.*, u.first_name, u.last_name, SUM(oi.qty * oi.price) as total_amount FROM orders o
    left JOIN users u ON o.user_id = u.id
    left join order_items oi ON o.id = oi.order_id
    group BY o.id
    order BY o.created_at DESC");

    $sql->execute();
    $data["orders"] = $sql->fetchAll(PDO::FETCH_ASSOC);

    return $data;
}

function edit_order($id) {
    global $conn;
    $data = [];
    $sql = $conn->prepare("SELECT o.*, u.*, z.city as city, SUM(oi.qty * oi.price) as total_amount FROM orders o
    left join order_items oi ON o.id = oi.order_id
    left join users u ON o.user_id = u.id
    left join zip_code z ON u.irsz = z.code
    WHERE o.id = :id
    GROUP BY o.id");

    $sql->execute(["id" => $id]);
    $data["order"] = $sql->fetch(PDO::FETCH_ASSOC);

    $sql_items = $conn->prepare("SELECT oi.*, p.product_name FROM order_items oi
    LEFT JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = :id");

    $sql_items->execute(["id" => $id]);
    $data["order_items"] = $sql_items->fetchAll(PDO::FETCH_ASSOC);

    return $data;
}

function update_order_status($id, $newStatus){
    global $conn;
    
    $sql = $conn->prepare("UPDATE orders 
                          SET status = :status
                          WHERE id = :id");
    $sql->execute([
        "status" => $newStatus,
        "id" => $id
    ]);
}

function edit_user($id) {
    global $conn;
    $data = [];
    $sql = $conn->prepare("SELECT * FROM users WHERE id = :id");

    $sql->execute(["id" => $id]);
    $data["user"] = $sql->fetch(PDO::FETCH_ASSOC);

    return $data;
}
?>