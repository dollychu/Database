<?php

require_once "utils.php";

function getIdMusic($url){
  require_once "login2.php";
  $conn = get_connection();
  
  $url_ = decodeUrlVar($url, "path");
  $url  = empty($url_) ? $url : $url_;
  $path = preg_match("/^path=/", $url) ? urldecode(explode('path=', $url)[1]) : urldecode($url);

  $query = "SELECT IdMusic FROM Music WHERE MusicStoredPath='$path'";
  if(!$result = $conn->query($query)){
    echo "Failed processing the query: ".$query;
    $conn->close();
    return;
  }
  $mid = $result->fetch_assoc()['IdMusic'];

  return $mid;
}

function getDescription($mid){
  if(preg_match("/[^\d]/", $mid)) $mid = getIdMusic($mid);

  require_once "login2.php";
  $conn = get_connection();

  $query = "SELECT Description FROM Music WHERE IdMusic=$mid";
  if(!$result = $conn->query($query)){
    $conn->close();
    return "Can't fetch description.".$mid;
  }
  $description = $result->fetch_array()[0];
  $conn->close();
  
  return $description;
}

function getUploader($mid){
  if(preg_match("/[^\d]/", $mid)) $mid = getIdMusic($mid);

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

function getViewedNum($mid){
  if(preg_match("/[^\d]/", $mid)) $mid = getIdMusic($mid);

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

function getMusicName($mid){
  if(preg_match("/[^\d]/", $mid)) $mid = getIdMusic($mid);

  require_once "login2.php";
  $conn = get_connection();

  $query = "SELECT Name FROM Music WHERE IdMusic=$mid";
  if(!$result = $conn->query($query)){
    $conn->close();
    return "Can't fetch music name.";
  }
  $name = $result->fetch_array()[0];
  $conn->close();
  
  return $name;
}

function getUploadDate($mid){
  if(preg_match("/[^\d]/", $mid)) $mid = getIdMusic($mid);

  require_once "login2.php";
  $conn = get_connection();

  $query = "SELECT CreateAt FROM Music WHERE IdMusic=$mid";
  if(!$result = $conn->query($query)){
    $conn->close();
    return "Can't fetch upload date.";
  }
  $date = $result->fetch_array()[0];
  $conn->close();
  
  return explode(' ', $date)[0];
}

function getTag($mid){
  if(preg_match("/[^\d]/", $mid)) $mid = getIdMusic($mid);

  require_once "login2.php";
  $conn = get_connection();

  $query = "SELECT TagName FROM Tag NATURAL JOIN Music WHERE IdMusic=$mid";
  if(!$result = $conn->query($query)){
    $conn->close();
    return "Can't fetch tag.";
  }
  
  while($row = $result->fetch_row()){
    $tag[] = $row[0];
  }
  
  $conn->close();
  
  return $tag;
}

function getPath($mid){
  require_once "login2.php";
  $conn = get_connection();

  $query = "SELECT MusicStoredPath FROM Music WHERE IdMusic=$mid";
  if(!$result = $conn->query($query)){
    $conn->close();
    return "Can't fetch stored path.";
  }
  $path = $result->fetch_array()[0];
  $conn->close();
  
  return $path;
}



?>
