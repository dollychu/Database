<?php

require_once "login2.php";
$conn = get_connection();

session_start();

$mid = $_POST['IdMusic'];

$query = "SELECT MusicStoredPath FROM Music WHERE IdMusic=$mid";
$ss = $conn->query($query);
$path = $ss->fetch_assoc()['MusicStoredPath'];
$ss->close();

$query = "DELETE FROM Music WHERE IdMusic=$mid";

if($result = $conn->query($query)){
  unlink("../Music/$path");
  echo "Removed";
  
  // Update user data
  $updateTime = date("Y-m-d H:i:s");
  $query = "UPDATE User SET UpdateAt='$updateTime' WHERE IdUser={$_SESSION['IdUser']}";
  $conn->query($query);
  
  $conn->close();
  return 1;
}

echo "Failed to execute query!";
$conn->close();
return 0;



?>
