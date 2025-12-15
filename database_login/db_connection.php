<?php
$servername = "localhost";
$username = "root";
$password = "Root@123";
$dbname = "tmpUser";

try {
  $conn = new PDO("mysql:host=$servername;dbname=tmpUser", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

// try {
//     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//     // set the PDO error mode to exception
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
//     // sql to create table
//     $sql = "CREATE TABLE user (
//     user_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//     username VARCHAR(30) NOT NULL,
//     email VARCHAR(50) NOT NULL,
//     phone_no VARCHAR(50) NOT NULL,
//     `password` VARCHAR(50) NOT NULL
//     )";
  
//     // use exec() because no results are returned
//     $conn->exec($sql);
//     echo "Table users created successfully";
//   } catch(PDOException $e) {
//     echo $sql . "<br>" . $e->getMessage();
//   }
  
//   $conn = null;
?>