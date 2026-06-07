<?php
$servername = "localhost";
$username = "root";
$password = "#NguyenAnh1";

try {
  $conn = new PDO("mysql:host=$servername;dbname=secondhand", $username, $password);
  
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>