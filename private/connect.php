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


function sections(){
    global $conn;
    $data = [];
    $sql = $conn->prepare("SELECT * FROM section");

    $sql->execute();
    $data["sections"] = $sql->fetchAll(PDO::FETCH_ASSOC);

    $sql = $conn->prepare("SELECT id, name, author_name, substring(content, 1, 30) as content from thread
          ORDER BY created_at DESC
          LIMIT 5");

    $sql->execute();
    $data["topThreads"] = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}

function getThreads($s_id){
    global $conn;
    $sql = $conn->prepare("SELECT DISTINCT t.id, t.name, t.author_name, t.section_id, t.is_archived, t.created_at, c.author_name AS c_author_name, c.created_at AS c_created_at
        FROM thread AS t
        LEFT JOIN comment AS c
            ON c.thread_id = t.id 
            AND c.created_at = (
                SELECT MAX(created_at) 
                FROM comment 
                WHERE thread_id = t.id
            )
        WHERE t.section_id = :s_id
        ORDER BY t.is_archived, c.created_at DESC");

    $sql->execute(["s_id" => $s_id]);
    $query = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $query;
}

function createThread($id, $data){
  global $conn;
  
  $sql = $conn->prepare("INSERT INTO `thread` (`name`, `author_name`, `content`, `section_id`) VALUES (:threadname, :name, :comment, :section_id)");
  $sql->execute([
    ...$data,
    'section_id' => $id,
  ]);
}

function archived($id) {
  global $conn;
  
  $sql = $conn->prepare("UPDATE thread 
                        SET is_archived = 1 
                        WHERE id = :id");
  $sql->execute(["id" => $id]);
}

function deleteComment($id) {
  global $conn;
  
  $sql = $conn->prepare("DELETE FROM comment 
                        WHERE id = :id");
  $sql->execute(["id" => $id]);
}
?>