<?php

require_once "login2.php";
$conn = get_connection();


require_once "GetMusicInfo.php";
$mid = getIdMusic("path=".$_POST['music_path']);

session_start();
$uid = isset($_SESSION['IdUser']) ? $_SESSION['IdUser'] : 21;

$query = "INSERT INTO Viewed(IdUser, IdMusic) VALUES($uid, $mid)";
if(!$conn->query($query)){
  echo "Failed to update viewed number: ".$query;
}
$conn->close();

?>
