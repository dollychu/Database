<?php

function getIdMusic($url){
  require_once "login2.php";
  $conn = get_connection();

  $path = urldecode(explode('path=', $url)[1]);
  $query = "SELECT IdMusic FROM Music WHERE MusicStoredPath='$path'";
  if(!$result = $conn->query($query)){
    echo "Failed processing the query: ".$query;
    $conn->close();
    return;
  }
  $mid = $result->fetch_assoc()['IdMusic'];

  return $mid;
}

function getUploader($music_path){
  $mid = getIdMusic($music_path);

  require_once "login2.php";
  $conn = get_connection();

  $query = "SELECT User.Name as name
            FROM User INNER JOIN Music
            WHERE IdMusic=$mid AND User.IdUser=Music.UploadUser";

  if(!$result = $conn->query($query)){
    echo "Failed to fetch uploader.";
    $conn->close();
    return "Failed to fetch uploader";
  }
  $name = $result->fetch_assoc()['name'];

  return $name;
}

function getViewedNum($music_path){
  $mid = getIdMusic($music_path);

  require_once "login2.php";
  $conn = get_connection();
  
  $query = "SELECT COUNT(IdUser) AS viewed FROM Viewed WHERE IdMusic=$mid";
  if(!$result = $conn->query($query)){
    echo "Failed to load viewed number.";
    $conn->close();
    return 0;
  }

  $num = $result->fetch_array()[0];
  $result->free();
  $conn->close();

  return $num;
}

?>
