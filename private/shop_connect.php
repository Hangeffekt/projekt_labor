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