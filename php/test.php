<?php
require_once "login.php";

$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die($conn->connect_error);

$name = "JJ";
$query = "SELECT UID FROM User WHERE Name='{$name}'";

if($result = $conn->query($query)){
  $row = $result->fetch_assoc();
  printf($row['UID']);
}

?>
