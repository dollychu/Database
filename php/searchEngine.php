<?php

function preProcessStr($str){
  if(empty($str) || preg_match("/^ *$/", $str)){
    return '';
  }
  $pattern = "/[^A-Za-z0-9_\s]/";
  $replacement = "";
  $new = preg_replace($pattern, $replacement, $str);
  $new = "%".str_replace(" ", "%", $new)."%";
  
  return $new;
}

function getQueryList(){
  $query[] = "SELECT IdMusic FROM Music WHERE Name LIKE ?";
  $query[] = "SELECT DISTINCT(IdMusic), Name 
              FROM Tag NATURAL RIGHT OUTER JOIN Music 
              WHERE TagName LIKE ? OR Name LIKE ?";

  return $query;
}


function search($str){
  $str = preProcessStr($str);

  require_once "login2.php";
  $conn = get_connection();
  $stmt = $conn->stmt_init();

  $query = getQueryList();

  if(!$stmt->prepare($query[1])){
    echo "Failed to prepare query.";
    return;
  }
  $stmt->bind_param('ss', $str, $str);
  $stmt->execute();

  $result = $stmt->get_result();
  $ret_v = array();
  while($row = $result->fetch_row()){
    $ret_v[] = $row[0];
  }

  $result->free();
  $stmt->close();
  $conn->close();

  return $ret_v;
}




?>
