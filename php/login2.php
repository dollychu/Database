<?php

function get_connection(){
  $hn = "localhost";
  $db = "DB_project";
  $un = "dbteam16";
  $pw = "DBteam16;";
  $conn = new mysqli($hn, $un, $pw, $db);
  if($conn->connect_error) die($conn->connect_error);
  
  return $conn;
}

?>
